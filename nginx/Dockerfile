FROM nginx:alpine

# 複製虛擬主機設定到容器內
COPY docker/nginx.conf /etc/nginx/sites-available/default

# 暴露 80 端口
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]