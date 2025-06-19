import pandas as pd
import joblib
import sys

# model = joblib.load("C:\\xampp\\htdocs\\demoiot\\decision_tree_model.joblib")
model = joblib.load("C:\\xampp\\htdocs\\demoiot\\random_forest.joblib")

# ax = float(sys.argv[1])
# ay = float(sys.argv[2])
# az = float(sys.argv[3])
gx = float(sys.argv[1])
gy = float(sys.argv[2])
gz = float(sys.argv[3])
magnitude =float(sys.argv[4])
# ax = 0.18
# ay = 1.18
# az = -0.4
# gx = 34.38
# gy = -3.4
# gz = 79.24
# magnitude = 1.25
data_values = [gx,gy,gz,magnitude]
# print(data_values)
new_data = pd.DataFrame([data_values], columns=['gx', 'gy', 'gz', 'magnitude'])
prediction = model.predict(new_data)
print(prediction[0])
