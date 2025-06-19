#include <Wire.h>
#include <MPU6050.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char *ssid = "TP-Link_psd912";
const char *password = "123456788";
const char *host = "http://192.168.0.100/demoiot/getdemo.php";
const char *frequencyHost = "http://192.168.0.100/demoiot/get_frequency.php";

MPU6050 mpu;
int sendFrequency = 1000;

void setup() {
    Serial.begin(115200);
    Wire.begin(4, 5);
    mpu.initialize();

    if (mpu.testConnection()) {
        Serial.println("MPU6050 kết nối thành công!");
    } else {
        Serial.println("Kết nối MPU6050 thất bại!");
    }

    WiFi.begin(ssid, password);
    Serial.print("Đang kết nối tới WiFi");
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
    Serial.println("\nĐã kết nối tới WiFi!");
    Serial.print("Địa chỉ IP: ");
    Serial.println(WiFi.localIP());
}

void updateFrequency() {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin(frequencyHost);
        int httpCode = http.GET();
        if (httpCode > 0) {
            String payload = http.getString();
            sendFrequency = payload.toInt();  
            Serial.println("Tần suất mới: " + String(sendFrequency) + " ms");
        } else {
            Serial.println("Chưa nhận được dữ liệu từ server");
        }
        http.end();
    }
}

void loop() {
    int16_t ax, ay, az;
    int16_t gx, gy, gz;

    mpu.getMotion6(&ax, &ay, &az, &gx, &gy, &gz);
    
    float ax_g = ax / 16384.0;
    float ay_g = ay / 16384.0;
    float az_g = az / 16384.0;

    float gx_dps = gx / 131.0;
    float gy_dps = gy / 131.0;
    float gz_dps = gz / 131.0;

    float magnitude = sqrt(ax_g * ax_g + ay_g * ay_g + az_g * az_g);

    String postData = "ax=" + String(ax_g) + "&ay=" + String(ay_g) + "&az=" + String(az_g) +
                      "&gx=" + String(gx_dps) + "&gy=" + String(gy_dps) + "&gz=" + String(gz_dps) +
                      "&magnitude=" + String(magnitude);
    Serial.print(postData);

    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin(host);  
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        int httpCode = http.POST(postData);
        if (httpCode > 0) {
            String payload = http.getString();
        } else {
            Serial.println("Gửi dữ liệu thất bại!");
        }
        
        http.end();
    } else {
        Serial.println("WiFi không kết nối!");
    }
    updateFrequency(); 
    sendFrequency=sendFrequency-3000;
    delay(sendFrequency);  
    Serial.println(sendFrequency);
}
