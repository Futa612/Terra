import cv2
import imutils
from imutils.video import FPS
import numpy as np
import time
import psutil
import threading
import pygame
import random
import requests

checkid = 3

def get_yolo_preds(net, input_vid_path="input_video/test50.mp4", output_vid_path="output_video/yolo_output.avi", confidence_threshold=0.5, overlapping_threshold=0.3, write_output=False, show_display=True, labels = None):
    # Get layer names that output predictions from YOLO
    # List of colors to represent each class label with distinct color
    get_yolo_preds.checkid = 2
    get_yolo_preds.lenbbox = 0

    np.random.seed(20)
    colors = np.random.randint(0, 150, size=(len(labels), 3), dtype="uint8")
    ln = net.getLayerNames()
    ln = [ln[i - 1] for i in net.getUnconnectedOutLayers()]
    W = None
    H = None
    cap = cv2.VideoCapture(input_vid_path)
    t0 = 0
    if (cap.isOpened() == False):
        print("Error opening video stream or file")
        return

    (success, frame) = cap.read()
    
    # frame = imutils.resize(frame, width=640)
    if write_output:

        out = cv2.VideoWriter(output_vid_path, cv2.VideoWriter_fourcc(
            *"MJPG"), cap.get(cv2.CAP_PROP_FPS), (frame.shape[1], frame.shape[0]), True)

    while success:
        # frame = imutils.resize(frame, width=640)
        if W is None or H is None:
            (H, W) = frame.shape[:2]

        # Construct blob of frames by standardization, resizing, and swapping Red and Blue channels (RBG to RGB)
        blob = cv2.dnn.blobFromImage(
            frame, 1 / 255.0, (416, 416), swapRB=True, crop=False)
        net.setInput(blob)
        layerOutputs = net.forward(ln)
        boxes = []
        confidences = []
        classIDs = []
        for output in layerOutputs:
            for detection in output:
                scores = detection[5:]
                classID = np.argmax(scores)
                confidence = scores[classID]
                if confidence > confidence_threshold:
                    # Scale the bboxes back to the original image size
                    box = detection[0:4] * np.array([W, H, W, H])
                    (centerX, centerY, width, height) = box.astype("int")
                    x = int(centerX - (width / 2))
                    y = int(centerY - (height / 2))
                    boxes.append([x, y, int(width), int(height)])
                    confidences.append(float(confidence))
                    classIDs.append(classID)   
                    get_yolo_preds.checkid = classID
                   
        # Remove overlapping bounding boxes and bounding boxes
        bboxes = cv2.dnn.NMSBoxes(
            boxes, confidences, confidence_threshold, overlapping_threshold)
        if len(bboxes) > 0:
            for i in bboxes.flatten():
                (x, y) = (boxes[i][0], boxes[i][1])
                (w, h) = (boxes[i][2], boxes[i][3])
                color = [int(c) for c in colors[classIDs[i]]]
                cv2.rectangle(frame, (x, y), (x + w, y + h), color, 3)
                (text_w, text_h), baseline = cv2.getTextSize(labels[classIDs[i]], cv2.FONT_HERSHEY_SIMPLEX, 0.6,1)
                cv2.rectangle(frame, (x, y), (x + text_w + 50, y - text_h - baseline), color , thickness=cv2.FILLED)		
                text = "{}: {:.2f}%".format(labels[classIDs[i]], confidences[i]*100)
                cv2.putText(frame, text, (x, y - 5),
                            cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0,0,0), 2)

        get_yolo_preds.lenbbox = len(bboxes)
        # print(get_yolo_preds.lenbbox)

        if show_display:
            cv2.imshow("Predictions", frame)
            key = cv2.waitKey(1) & 0xFF
            # if the `q` key was pressed, break the loop
            if key == ord("q"):
                break

        if write_output:
            out.write(frame)

        #Show frame per second 
        t1 = time.time()
        fps = 1/(t1 - t0)
        t0 = t1
        (success, frame) = cap.read()

        cv2.putText(frame,"CPU:",(20,20), 2, 0.6, (189, 123, 10),2)
        cv2.putText(frame," {:.0f}%".format(psutil.cpu_percent()) , (60,20), 2 ,0.6,(13,129,248),2)

        cv2.putText(frame,"RAM:",(20,50), 2, 0.6, (189, 123, 10),2)
        cv2.putText(frame," {:.0f}%".format(psutil.virtual_memory().percent) , (60,50), 2 ,0.6,(13,129,248),2)

        cv2.putText(frame,"FPS:",(20,80), 2, 0.6, (189, 123, 10),2)
        cv2.putText(frame," {:.0f}".format(fps) , (60,80), 2 ,0.75,(128, 127, 191),2)
        cv2.putText(frame,"fps" , (110,80), 0 ,0.5,(128, 127, 191),2)
        
    cap.release()
    if write_output:
        out.release()
    cv2.destroyAllWindows()

def sendRequestData(payload):
    myRequest = requests.get('https://xemsao.com/sensorMask.php', params = payload)

def warning():
    
    timeCountDown = 0
    maskedNum = 0
    unMaskedNum = 0
    
    warning = ['warning_sound/warning-1.mp3', 'warning_sound/warning-2.mp3', 'warning_sound/warning-3.mp3', 'warning_sound/warning-4.mp3', 'warning_sound/warning-5.mp3','warning_sound/warning-6.mp3']
    while True:
        # Someone is infront of camera
        if get_yolo_preds.lenbbox > 0:

            # There is 1 people or more than one who not wearing mask
            if get_yolo_preds.checkid == 1:
                pygame.mixer.init()
                pygame.mixer.music.load(random.choice(warning))
                pygame.mixer.music.play()

                # Control data: Add the number of masked people
                unMaskedNum = unMaskedNum + get_yolo_preds.lenbbox

                # Send http request to website
                payload = {'maskedNum' : str(maskedNum), 'unMaskedNum' : str(unMaskedNum)}
                sendRequestData(payload)
                
                time.sleep(5)
                while pygame.mixer.music.get_busy() == True:
                    continue

            # All people are wearing mask        
            if get_yolo_preds.checkid == 0:
                timeCountDown = timeCountDown + 1

                if timeCountDown == 30:
                    timeCountDown = 0

                    # Control data: Add the number of masked people
                    maskedNum = maskedNum + 1

                    # Send http request to website
                    payload = {'maskedNum' : str(maskedNum), 'unMaskedNum' : str(unMaskedNum)}
                    sendRequestData(payload)

                    # People can pass by 
                    pygame.mixer.init()
                    pygame.mixer.music.load("success_sound/Crystal-01.wav")
                    pygame.mixer.music.play()
                    time.sleep(2)
                continue

        # Nobody is in front of camera
        if get_yolo_preds.lenbbox == 0:
            timeCountDown = 0
