# Utiliser l'image Node.js officielle
FROM node:16

# Définir le répertoire de travail à l'intérieur du conteneur
WORKDIR /app

# Copier les fichiers package.json et package-lock.json pour installer les dépendances
COPY package*.json ./

# Installer les dépendances du projet avec l'option --legacy-peer-deps
RUN yarn install
# Copier tout le projet dans le répertoire de travail du conteneur
COPY . .

# Exposer le port sur lequel l'application s'exécute
EXPOSE 8080

# Ouvrir un shell interactif pour pouvoir exécuter des commandes npm
CMD ["/bin/bash"]
