import pandas as pd
import matplotlib.pyplot as plt

datos = pd.read_csv("C:/xampp/htdocs/sgpi-laravel/resources/views/Statistics/casasboston.csv")
#datos = datos[["RM","CRIM", "MEDV", "TOWN", "CHAS", "INDUS", "LSTAT"]]
df = datos[["RM","CRIM", "MEDV", "TOWN", "CHAS"]]

df = datos.rename(columns={
	"TOWN":"CIUDAD",
	"CRIM":"INDICE_CRIMEN",	
	"INDUS":"PCT_ZONA_INDUSTRIAL",
	"CHAS":"RIO_CHARLES",
	"RM":"N_HABITACIONES_MEDIO",
	"MEDV":"VALOR_MEDIANO",
	"LSTAT":"PCT_CLASE_BAJA"
})
#result=df.sample(5).to_html()
#print(result)

df.N_HABITACIONES_MEDIO.plot.hist()
plt.show()
#print (df.sample(5))