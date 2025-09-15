# imagem base 
FROM node

# criando diretorio de trabalho
WORKDIR /app

# copiando os arquivos (.) significa que vai copiar tudo da pasta raiz
COPY package*.json .

# INSTALANDO AS DEPENDENCIAS
RUN npm install

# COPIANDO TUDO DO DESTINO PARA ORIGEM
COPY . .

# PORTA DO IMAGEM 
EXPOSE 3333

# COMANDO DE EXECUÇÃO DA IMAGEM
# 
CMD ["npm", "run", "dev"]

