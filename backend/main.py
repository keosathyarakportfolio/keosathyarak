from fastapi import FastAPI, Query, HTTPException, BackgroundTasks
from fastapi.responses import FileResponse
from pathlib import Path
import subprocess, json, os, uuid

app = FastAPI()

YT_DLP_PATH = "yt-dlp"

FFMPEG_PATH = "ffmpeg"

DOWNLOAD_DIR = "downloads"
os.makedirs(DOWNLOAD_DIR, exist_ok=True)


def human_size(size_bytes):
    if not size_bytes:
        return "Unknown"
    for unit in ['B','KB','MB','GB','TB']:
        if size_bytes < 1024:
            return f"{size_bytes:.2f} {unit}"
        size_bytes /= 1024
    return f"{size_bytes:.2f} PB"


def delete_file(path: str):
    try:
        os.remove(path)
    except Exception as e:
        print(f"Failed to delete {path}: {e}")


@app.get("/get-video")
def get_video(url: str = Query(...)):
    url = url.strip()
    if not url:
        raise HTTPException(status_code=400, detail="URL មិនអាចទទេ")

    command = [YT_DLP_PATH, "-j", url]
    result = subprocess.run(command, capture_output=True, text=True)
    if result.returncode != 0:
        raise HTTPException(status_code=400, detail=f"Failed to fetch video info\n{result.stderr}")

    video_data = json.loads(result.stdout.splitlines()[-1])
    formats = []

    for f in video_data.get("formats", []):
        ext = f.get("ext")
        quality = f.get("height") or f.get("tbr") or 0
        formats.append({
            "format_id": f.get("format_id"),
            "quality": quality,
            "ext": ext,
            "acodec": f.get("acodec"),
            "vcodec": f.get("vcodec"),
            "filesize": human_size(f.get("filesize"))
        })

    formats = sorted(formats, key=lambda x: x["quality"], reverse=True)

    return {
        "title": video_data.get("title", "Unknown"),
        "thumbnail": video_data.get("thumbnail", ""),
        "duration": video_data.get("duration", 0),
        "formats": formats
    }


@app.get("/download-video")
def download_video(
    url: str = Query(...),
    video_format_id: str = Query(...),
    background_tasks: BackgroundTasks = None
):
    url = url.strip()
    if not url:
        raise HTTPException(status_code=400, detail="URL មិនអាចទទេ")

    temp_file = os.path.join(DOWNLOAD_DIR, f"{uuid.uuid4()}.%(ext)s")
    format_option = f"{video_format_id}+bestaudio/best"

    FFMPEG_PATH = "/usr/bin/ffmpeg"

    command = [
        YT_DLP_PATH,
        "-f", format_option,
        "-o", temp_file,
        "--merge-output-format", "mp4",
        "--ffmpeg-location", FFMPEG_PATH,
        "--postprocessor-args:ffmpeg", "-c:v libx264 -c:a aac",
        url
    ]

    print("Running command:", " ".join(command))  # Optional debug log

    result = subprocess.run(command, capture_output=True, text=True)
    if result.returncode != 0:
        raise HTTPException(status_code=400, detail=f"ទាញវីដេអូបរាជ័យ:\n{result.stderr}")

    downloaded_file = temp_file.replace("%(ext)s", "mp4")
    if not os.path.exists(downloaded_file):
        raise HTTPException(status_code=500, detail="ឯកសារដែលទាញមិនមាន")

    background_tasks.add_task(delete_file, downloaded_file)

    return FileResponse(downloaded_file, filename=os.path.basename(downloaded_file))