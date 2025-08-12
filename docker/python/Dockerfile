FROM python:3.9-slim-buster

WORKDIR /app

RUN apt-get update
RUN apt-get install -y graphviz

# 必要なパッケージをインストール
RUN pip install diagrams graphviz