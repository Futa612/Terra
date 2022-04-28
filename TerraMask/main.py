import cv2
from my_utils import get_yolo_preds, warning
import threading

idcheck = 3
#Read labels:
# with open("yolo6.names", "r", encoding = "utf-8") as f:
#     labels = f.read().strip().split("\n")
with open("mask2/main/obj.names", "r", encoding = "utf-8") as f:
    labels = f.read().strip().split("\n")

#Set parameters:
yolo_config_path = "mask2/main/yolov4-custom.cfg"
yolo_weights_path = "yolov4_weights/training/yolov4-custom_best.weights"

# yolo_config_path = "mask2/main/yolov4-custom.cfg"
# yolo_weights_path = "mask2/main/yolov4-custom_last.weights"

net = cv2.dnn.readNetFromDarknet(yolo_config_path, yolo_weights_path)

input_vid_path = 0
# input_vid_path = "input_video/test50.mp4"

cuda = True
show_display = True

write_output = False
output_vid_path = ""

confidence_threshold = 0.5
overlapping_threshold = 0.3
##############################################################

if cuda:
    net.setPreferableBackend(cv2.dnn.DNN_BACKEND_CUDA)
    net.setPreferableTarget(cv2.dnn.DNN_TARGET_CUDA)
##############################################################

if __name__ == '__main__':
    # get_yolo_preds(net, input_vid_path, output_vid_path, confidence_threshold, overlapping_threshold, write_output, show_display, labels)
    thread1 = threading.Thread(target = get_yolo_preds, args = (net, input_vid_path, output_vid_path, confidence_threshold, overlapping_threshold, write_output, show_display, labels,))
    thread2 = threading.Thread(target = warning)

    thread1.start()
    thread2.start()

    # thread1.join()
    # thread2.join()

    