from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from typing import Dict
from decision_tree_model import (
    get_required_fields,
    predict_from_input_dict,
    get_available_csv_files
)

app = FastAPI()

class PredictRequest(BaseModel):
    file: str
    data: Dict[str, float]
    certificate_average_score: float 

@app.get("/files")
def list_csv_files():
    return {"files": get_available_csv_files()}

@app.get("/fields")
def get_fields(file: str):
    try:
        fields = get_required_fields(file)
        return {"fields": fields}
    except Exception as e:
        raise HTTPException(status_code=404, detail=str(e))

@app.post("/predict")
def predict_route(req: PredictRequest):
    try:
        input_data = req.data
        required = get_required_fields(req.file)
        cert_avg_score = req.certificate_average_score

        for field in required:
            if field not in input_data:
                raise HTTPException(status_code=400, detail=f"Field '{field}' wajib diisi.")
            try:
                input_data[field] = float(input_data[field])
            except:
                raise HTTPException(status_code=400, detail=f"Field '{field}' harus berupa angka.")

        prediction = predict_from_input_dict(req.file, input_data)
        selected_attributes = ["RATA_RATA", "MAT", "BIO", "KIM", "BIG"]
        selected_values = [input_data[attr] for attr in selected_attributes]
        avg_score = sum(selected_values) / len(selected_values)
        
        if avg_score < 75:
            prediction = 0
        else:
            prediction = predict_from_input_dict(req.file, input_data)

      
        if prediction == 1:
            score = 50 + cert_avg_score
        else:
            score = 25 + cert_avg_score

        result = {
            "prediction": prediction,
            "score": score
        }

        return result

    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
    