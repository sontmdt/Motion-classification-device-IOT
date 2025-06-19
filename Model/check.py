import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report

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

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

model = RandomForestClassifier(n_estimators=50)
model.fit(X_train, y_train)

y_pred = model.predict(X_test)

accuracy = accuracy_score(y_test, y_pred)
print(f'Độ chính xác: {accuracy * 100:.2f}%')
print(classification_report(y_test, y_pred))
