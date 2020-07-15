import cv2
import numpy as np
import os.path


class FaceRecognizer:
    #   Поиск лиц на изображении

    face_cascade_classifier_path = 'FaceRecognition/xml/haarcascade_frontalface_default.xml'    # путь к xml-модели
    face_cascade_classifier = None      # модель для распознавания

    def __init__(self):
        #   Принимает - ничего
        #   Проверяет наличие xml файла
        #       если файл есть - создаёт модель для распознавания
        #       если файла нет - кидает исключение
        if not os.path.isfile(self.face_cascade_classifier_path):
            raise Exception("Not found: " + self.face_cascade_classifier_path)
        self.face_cascade_classifier = cv2.CascadeClassifier(self.face_cascade_classifier_path)

    def find_faces(self, img, colored=True, scale_factor=1.2, min_neighbors=7, min_size=(48, 48)):
        #   Поиск лиц на изображении
        #   Принимает:
        #       img - изображение для распознавания в виде массива
        #       colored - является ли изображение цветным
        #       scale_factor - множитель каскадирования
        #       min_neighbors - минимальное количество объектов, чтобы распознать лицо
        #       min_size - минимальный размер найденного лица
        #   Возвращает:
        #   bool есть ли лица на изображении
        #   массив координат лиц: x,y,ширина,высота
        #   !!!!! Почему то не завершается исполнение после использования !!!!!

        img = np.asarray(img)

        if colored:
            img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)     # переводим изображение в чб если оно цветное

        faces = self.face_cascade_classifier.detectMultiScale(  # использование модели для нахождения лиц
            img,  # изображение
            scaleFactor=scale_factor,  # множитель уменьшения изображения при каскадировании
            minNeighbors=min_neighbors,  # минимальное количество найденных элементов для распознавания лица
            minSize=min_size  # минимальный размер найденного лица
        )

        return not len(faces) == 0, faces
