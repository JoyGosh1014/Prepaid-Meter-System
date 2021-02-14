#!C:/Users/User/AppData/Local/Programs/Python/Python39/python.exe

import numpy as np
import pandas as pd


# Importing the dataset

dataset = pd.read_csv('test.csv')
x = dataset.iloc[:,:-1].values
y = dataset.iloc[:-1,-1].values

from sklearn.preprocessing import LabelEncoder, OneHotEncoder
labelencoder = LabelEncoder()
x[:, 0] = labelencoder.fit_transform(x[:, 0])
x[:, 1] = labelencoder.fit_transform(x[:, 1])
x[:, 2] = labelencoder.fit_transform(x[:, 2])


onehotencoder = OneHotEncoder()
x = onehotencoder.fit_transform(x).toarray()

x = x[:, 1:]

x_new = x[-1,:]
x= x[:-1,:]
x_new = x_new.reshape((1, -1))


from sklearn.linear_model import LinearRegression
regressor = LinearRegression()
regressor.fit(x, y)

y_new = regressor.predict(x_new)
y_new = float(y_new)

print(y_new)
