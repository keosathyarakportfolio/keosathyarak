const { spawn } = require("child_process");
const os = require("os");
const fs = require("fs");

// Detect LAN IPv4
function getLocalIP() {
  const nets = os.networkInterfaces();
  for (const name of Object.keys(nets)) {
    for (const net of nets[name]) {
      if (net.family === "IPv4" && !net.internal) {
        return net.address;
      }
    }
  }
  return "127.0.0.1";
}

const IP = getLocalIP();
const PYTHON_DIR = "backend";
const LARAVEL_DIR = "./";
const PYTHON_FILE = `${PYTHON_DIR}/main.py`;

// Check files exist
if (!fs.existsSync(PYTHON_FILE)) {
  console.error(`Python folder "${PYTHON_DIR}" មិនមាន main.py`);
  process.exit(1);
}
if (!fs.existsSync(`${LARAVEL_DIR}/artisan`)) {
  console.error(`Laravel folder "${LARAVEL_DIR}" មិនមាន artisan`);
  process.exit(1);
}

let processes = [];

// Start Python Backend
const pythonBackend = spawn("cmd.exe", [
  "/c", "cd", "/d", PYTHON_DIR, "&&",
  "uvicorn", "main:app", "--reload", "--host", "0.0.0.0", "--port", "8000"
], { stdio: "inherit" });

processes.push(pythonBackend);

// Delay before Laravel
setTimeout(() => {
  const laravelFrontend = spawn("cmd.exe", [
    "/c", "cd", "/d", LARAVEL_DIR, "&&",
    "php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8001"
  ], { stdio: "inherit" });

  processes.push(laravelFrontend);
}, 2000);

console.log("\n----------------------------------");
console.log(`Python backend:  http://${IP}:8000`);
console.log(`Laravel frontend: http://${IP}:8001`);
console.log("----------------------------------");

// Kill child processes on exit
function cleanup() {
  console.log("\nStopping services...");
  processes.forEach(p => p.kill());
  process.exit();
}

process.on("SIGINT", cleanup);
process.on("SIGTERM", cleanup);
