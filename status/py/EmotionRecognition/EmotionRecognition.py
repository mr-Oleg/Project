from tensorflow import keras
import numpy as np
import cv2
import os.path


class EmotionRecognizer:
    #   Распознавание эмоций

    anger_model_path = "EmotionRecognition/models/anger.nn"   # пути к моделям
    sadness_model_path = "EmotionRecognition/models/sadness.nn"
    happiness_model_path = "EmotionRecognition/models/happiness.nn"

    anger_model = None      # загруженные модели
    sadness_model = None
    happiness_model = None

    def __init__(self, init_anger=True, init_sadness=True, init_happiness=True):
        #   Принимает:
        #       init_anger - загрузить модель распознавания злости
        #       init_sadness - загрузить модель распознавания грусти
        #       init_happiness - загрузить модель распознавания счастья
        #   Если не заагружена ни одна модель - исключение

        if not init_anger and not init_sadness and not init_happiness:  # если не заагружена ни одна модель - исключение
            raise Exception("Nothing chosen")

        if init_anger:      # загрузить модель, если выбрана
            if not os.path.isdir(self.anger_model_path):
                raise Exception("Not found: " + self.anger_model_path)
            self.anger_model = keras.models.load_model(self.anger_model_path)
        if init_sadness:
            if not os.path.isdir(self.sadness_model_path):
                raise Exception("Not found: " + self.sadness_model_path)
            self.sadness_model = keras.models.load_model(self.sadness_model_path)
        if init_happiness:
            if not os.path.isdir(self.happiness_model_path):
                raise Exception("Not found: " + self.happiness_model_path)
            self.happiness_model = keras.models.load_model(self.happiness_model_path)

    def recognize(self, face_img, recognize_anger=True, recognize_sadness=True, recognize_happiness=True, colored=True):
        #   Принимает:
        #       face_img - изображение лица в виде массива
        #       recognize_anger - распознавать злость
        #       recognize_sadness - распознавать грусть
        #       recognize_happiness - распознавать счастье
        #       colored - цветное изображение
        #   Если не выбрано ни одно распознавание - Исключение
        #   Если выбрано распознавание, а модель не загружена - Исключение
        #   Возвращает числа в отрезке [0, 1] в порядке: злость -> грусть -> счастье , в виде:
        #       массива - если выбрано более 1 распознавания
        #       числа - если выбрано только одно распознавание

        if not recognize_anger and not recognize_sadness and not recognize_happiness:
            raise Exception("Nothing chosen")   # если не выбрано ни одно распознавание - Исключение

        if self.anger_model is None and recognize_anger:
            raise Exception("Anger is not init")    # если выбрано распознавание, а модель не загружена - Исключение
        if self.sadness_model is None and recognize_sadness:
            raise Exception("Sadness is not init")
        if self.happiness_model is None and recognize_happiness:
            raise Exception("Happiness is not init")

        answers = []    # инициализация массива ответов

        face_img = np.asarray(face_img)     # переводизображение в массив numpy

        if colored:     # перевод цветного изображения в чб
            face_img = cv2.cvtColor(face_img, cv2.COLOR_BGR2GRAY)

        face_img = cv2.resize(face_img, (48, 48))   # изменение размера изображения на 48х48

        to_predict = np.asarray([face_img]).reshape((1, 48, 48, 1))     # изменение вормата массива для распознавания

        if recognize_anger:     # распознавание, если необходимо
            answers.append(self.anger_model.predict(to_predict)[0][0])
        if recognize_sadness:
            answers.append(self.sadness_model.predict(to_predict)[0][0])
        if recognize_happiness:
            answers.append(self.happiness_model.predict(to_predict)[0][0])

        if len(answers) == 1:   # если ответ один, то вернуть числом
            return answers[0]

        return answers
