from fastapi import FastAPI, Request, Form
from fastapi.middleware.cors import CORSMiddleware
import base64
from datetime import datetime
import json
import os

app = FastAPI()

# ================================
# CORS
# ================================
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

# Carpeta para guardar imágenes
SAVE_DIR = "imagenes_recibidas"
os.makedirs(SAVE_DIR, exist_ok=True)


@app.get("/")
def root():
    return {"mensaje": "Servidor FastAPI funcionando"}


# ==========================================================
# ENDPOINT PRINCIPAL /arduino
# - Acepta JSON directo
# - Acepta CSV
# - Acepta JSON + CSV form-urlencoded
# ==========================================================
@app.post("/arduino")
async def recibir_datos(request: Request):

    content_type = request.headers.get("content-type", "")

    # --------------------------------------------
    # 1) JSON DIRECTO
    # --------------------------------------------
    if "application/json" in content_type:
        data = await request.json()

        csv = data.get("csv", "")
        json_payload = data

        # aceptar ambos nombres
        imagen_base64 = data.get("imagen_base64") or data.get("foto")

    # --------------------------------------------
    # 2) FORM-DATA
    # --------------------------------------------
    else:
        form = await request.form()

        csv = form.get("csv", "")
        json_raw = form.get("json", "{}")

        imagen_base64 = form.get("imagen_base64") or form.get("foto")

        try:
            json_payload = json.loads(json_raw)
        except:
            json_payload = {"error": "json inválido"}

    # =====================================================
    # 🌐 PROCESAR CSV
    # =====================================================
    datos_csv = {}
    if csv:
        partes = csv.split(",")
        if len(partes) >= 4:
            datos_csv = {
                "pir": partes[0],
                "distancia": partes[1],
                "buzzer": partes[2],
                "severidad": partes[3]
            }

    # =====================================================
    # 🖼️ GUARDAR IMAGEN SI EXISTE
    # =====================================================
    filename = None

    if imagen_base64:
        # Remover "data:image..."
        if imagen_base64.startswith("data:image"):
            imagen_base64 = imagen_base64.split(",")[1]

        try:
            bytes_img = base64.b64decode(imagen_base64)
        except Exception as e:
            print("[ERROR DECODIFICANDO]:", e)
            return {"status": "error", "detalle": str(e)}

        timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
        filename = f"{SAVE_DIR}/captura_{timestamp}.jpg"

        with open(filename, "wb") as f:
            f.write(bytes_img)

        print(f"[OK] Imagen guardada: {filename}")

    # =====================================================
    # 📤 RESPUESTA COMPLETA (IMPRIMIR)
    # =====================================================
    respuesta = {
        "status": "ok",
        "csv": datos_csv,
        "json_payload": json_payload,
        "imagen_guardada": filename
    }

    print("\n======= RESPUESTA ENVIADA =======")
    print(json.dumps(respuesta, indent=4, ensure_ascii=False))
    print("=================================\n")

    return respuesta
