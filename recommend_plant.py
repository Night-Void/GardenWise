import sys
import pandas as pd # type: ignore
from sklearn.preprocessing import LabelEncoder, StandardScaler # type: ignore
import joblib # type: ignore

# Load pre-trained model, encoders, and scaler
model = joblib.load('randomforest_model.pkl')
label_encoders = joblib.load('label_encoders.pkl')
scaler = joblib.load('scaler.pkl')
label_encoder_y = joblib.load('label_encoder_y.pkl')

# Collecting input from PHP
user_input = {
    'Plant_type': sys.argv[1].strip(),  # Trim whitespace
    'Temperature': float(sys.argv[2]),
    'Humidity': float(sys.argv[3]),
    'Watering_frequency': sys.argv[4].strip(),  # Trim whitespace
    'Sunlight_requirement': sys.argv[5].strip(),  # Trim whitespace
    'Soil_type': sys.argv[6].strip(),  # Trim whitespace
    'Seasons': sys.argv[7].strip(),  # Trim whitespace
    'Thane_Location': sys.argv[8].strip()  # Trim whitespace
}

# Process input
for col, le in label_encoders.items():
    user_input[col] = le.transform([user_input[col]])[0]
numeric_data = scaler.transform(pd.DataFrame([[user_input['Temperature'], user_input['Humidity']]], columns=['Temperature', 'Humidity']))
combined_data = list(user_input.values())[:-2] + list(numeric_data[0])
feature_names = ['Plant_type', 'Temperature', 'Humidity', 'Watering_frequency', 'Sunlight_requirement', 'Soil_type', 'Seasons', 'Thane_Location']
combined_data_df = pd.DataFrame([combined_data], columns=feature_names)

# Predict recommendation
prediction = model.predict(combined_data_df)
recommended_plant = label_encoder_y.inverse_transform(prediction)[0]
print(recommended_plant)
