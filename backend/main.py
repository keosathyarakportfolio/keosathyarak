from fastapi import FastAPI, Query, HTTPException, BackgroundTasks
from fastapi.responses import FileResponse
import subprocess, json, os, uuid

app = FastAPI()

YT_DLP_PATH = "yt-dlp"  # ឬ full path to yt-dlp.exe
FFMPEG_PATH = r"ffmpeg"  # full path to ffmpeg.exe
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


@app.get("/get-video")
def get_video(url: str = Query(...)):
    url = url.strip()
    if not url:
        raise HTTPException(status_code=400, detail="URL មិនអាចទទេ")

    # ទាញ JSON info ពី yt-dlp
    command = [YT_DLP_PATH, "-j", url]
    result = subprocess.run(command, capture_output=True, text=True)
    if result.returncode != 0:
        raise HTTPException(status_code=400, detail=f"Failed to fetch video info\n{result.stderr}")

    video_data = json.loads(result.stdout.splitlines()[-1])
    formats = []

    for f in video_data.get("formats", []):
        # filter only mp4/m4a or webm
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

    # sort by quality descending
    formats = sorted(formats, key=lambda x: x["quality"], reverse=True)

    return {
        "title": video_data.get("title", "Unknown"),
        "thumbnail": video_data.get("thumbnail",""),
        "duration": video_data.get("duration",0),
        "formats": formats
    }


@app.get("/download-video")
def download_video(
    url: str = Query(...),
    video_format_id: str = Query(...),
    background_tasks: BackgroundTasks = None
):
    """
    video_format_id = selected by user
    audio = automatically bestaudio
    """
    url = url.strip()
    if not url:
        raise HTTPException(status_code=400, detail="URL មិនអាចទទេ")

    temp_file = os.path.join(DOWNLOAD_DIR, f"{uuid.uuid4()}.%(ext)s")

    format_option = f"{video_format_id}+bestaudio/best"  # merge selected video + best audio

    command = [
        YT_DLP_PATH,
        "-f", format_option,
        "-o", temp_file,
        "--merge-output-format", "mp4",
        "--ffmpeg-location", FFMPEG_PATH,
        url
    ]

    result = subprocess.run(command, capture_output=True, text=True)
    if result.returncode != 0:
        raise HTTPException(status_code=400, detail=f"ទាញវីដេអូបរាជ័យ:\n{result.stderr}")

    downloaded_file = temp_file.replace("%(ext)s","mp4")
    if not os.path.exists(downloaded_file):
        raise HTTPException(status_code=500, detail="ឯកសារដែលទាញមិនមាន")

    if background_tasks:
        background_tasks.add_task(lambda: os.remove(downloaded_file))

    return FileResponse(downloaded_file, filename=os.path.basename(downloaded_file))
