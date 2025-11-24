import uvicorn

if __name__ == "__main__":
    # Ejecuta el servidor Uvicorn apuntando al archivo main.py
    uvicorn.run(
        "main:app",   # main.py con variable app = FastAPI()
        host="0.0.0.0",
        port=8000,
        reload=True
    )
