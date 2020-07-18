import json
from flask import Flask, jsonify, request, render_template
from flask_cors import CORS, cross_origin
from io import BytesIO
import base64
import numpy as np
from PIL import Image as Img
from EmotionRecognition.EmotionRecognition import EmotionRecognizer as Er
from FaceRecognition.FaceRecognition import FaceRecognizer as Fr


app = Flask(__name__)
#CORS(app)
#app.config['CORS_HEADERS'] = 'Content-Type'

face_recognizer = None
emotion_recognizer = None


def img_decode(b64):
    img_bytes = BytesIO(base64.b64decode(b64))
    img = Img.open(img_bytes).convert('RGB')
    array = np.asarray(img)
    return array


@app.route('/rec_emotions', methods=['POST'])
#@cross_origin()
def rec_emotions():
    req_json = request.form['request']
    req = json.loads(req_json)
    b64 = req['img'].replace(" ", "+")
    img = img_decode(b64)
    answers = [-1, -1, -1]
    ret2, faces = face_recognizer.find_faces(img)
    if ret2:
        (x, y, w, h) = faces[0]
        crop_img = img[y:y + h, x:x + w]
        emotions = emotion_recognizer.recognize(crop_img)
        answers[0] = str(emotions[0])
        answers[1] = str(emotions[1])
        answers[2] = str(emotions[2])
    return jsonify({'type': "success", 'message': answers})


if __name__ == '__main__':
    face_recognizer = Fr()
    emotion_recognizer = Er()
    app.run(debug=True)

