import pandas as pd
from sklearn.tree import DecisionTreeClassifier
import joblib

data = pd.read_csv(
    "C:\\xampp\\htdocs\\demoiot\\Model\\data.txt", 
    sep=' ', 
    header=None, 
    names=['date', 'time', 'ax', 'ay', 'az', 'gx', 'gy', 'gz', 'magnitude', 'label'], 
    engine='python'
)

data['timestamp'] = data['date'] + ' ' + data['time']
data = data[['timestamp', 'ax', 'ay', 'az', 'gx', 'gy', 'gz', 'magnitude', 'label']]

data[['gx', 'gy', 'gz', 'magnitude']] = data[['gx', 'gy', 'gz', 'magnitude']].astype(float)

X = data[['gx', 'gy', 'gz', 'magnitude']]
y = data['label']

model = DecisionTreeClassifier()
model.fit(X, y)

joblib.dump(model, "C:\\xampp\\htdocs\\demoiot\\Model\\decision_tree_model.joblib")
print("Mô hình đã được lưu thành công!")
