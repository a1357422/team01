import cv2
import numpy as np
import sys


# 讀取兩張照片
img1 = cv2.imread(sys.argv[1], 0)
img2 = cv2.imread(sys.argv[2], 0)
# 創建ORB特徵檢測器和描述符
orb = cv2.ORB_create()

# 找到關鍵點和描述符
kp1, des1 = orb.detectAndCompute(img1, None)
kp2, des2 = orb.detectAndCompute(img2, None)

# 創建FLANN匹配器
index_params = dict(algorithm=6, table_number=6, key_size=12, multi_probe_level=2)
search_params = dict(checks=50)
flann = cv2.FlannBasedMatcher(index_params, search_params)

# 使用k-NN匹配算法找到最佳匹配
matches = flann.knnMatch(des1, des2, k=2)

# 提取最佳匹配的關鍵點
good_matches = []
for m, n in matches:
    if m.distance < 0.7 * n.distance:
        good_matches.append(m)

# 如果找到了足夠的好匹配，則認為兩張照片相同
if len(good_matches) > 10:
    print('success')
else:
    print('not same')
