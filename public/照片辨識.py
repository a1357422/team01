import dlib
import numpy as np
import cv2
import sys

def cv_imread(file_path):
    cv_img = cv2.imdecode(np.fromfile(file_path,dtype=np.uint8),-1)
    cv_img = cv2.cvtColor(cv_img, cv2.COLOR_RGB2BGR)
    return cv_img


# 加載dlib的人臉檢測器和特徵提取器
detector = dlib.get_frontal_face_detector()
predictor = dlib.shape_predictor("shape_predictor_68_face_landmarks_GTX.dat")
facerec = dlib.face_recognition_model_v1("dlib_face_recognition_resnet_model_v1.dat")

# 讀取兩張圖片
img1 = cv_imread(sys.argv[1])
img2 = cv_imread(sys.argv[2])

# 使用dlib.get_frontal_face_detector()方法獲取檢測器，並檢測兩張圖片中的所有人臉
face_detector = dlib.get_frontal_face_detector()
faces1 = face_detector(img1, 1)
faces2 = face_detector(img2, 1)

features1 = []
for face in faces1:
    shape = predictor(img1, face)
    features1.append(np.array(facerec.compute_face_descriptor(img1, shape)))

# 比較第二張圖片中的人臉和第一張圖片中的每個人臉
for face in faces2:
    shape = predictor(img2, face)
    features2 = np.array(facerec.compute_face_descriptor(img2, shape))
    
# 比較相似度
for feature in features1:
    distance = np.linalg.norm(feature - features2)
    if distance < 0.4:
        print('success')
        break
    else:
        print('not same')