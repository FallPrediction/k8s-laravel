# Laravel 13 Kubernetes 練習專案

這是一個使用 Kubernetes 部署 Laravel 13 的練習專案，示範如何將 Laravel 應用程式拆分成 API、Queue worker 與 Schedule。

專案包含以下服務：

- Laravel API
- Laravel Scheduler：執行 Laravel 排程任務
- Default Worker：處理發票與通知 Queue
- Inventory Worker：處理庫存 Queue
- PostgreSQL
- Redis
- Prometheus、Grafana
- Node Exporter、Alertmanager

## 部署方式

請先確認已連線至 Kubernetes 叢集，再依序執行以下指令：

```bash
kubectl apply -f postgres-pwd.yaml
kubectl apply -f postgres.yaml
kubectl apply -f redis.yaml
kubectl apply -f api-secret.yaml
kubectl apply -f api-cm.yaml
kubectl apply -f migration.yaml
kubectl apply -f api.yaml
kubectl apply -f worker-default.yaml
kubectl apply -f worker-inventory.yaml
kubectl apply -f schedule-deploy.yaml
kubectl apply -f node-exporter.yaml
kubectl apply -f prometheus-server.yaml
kubectl apply -f alert-manager.yaml
kubectl apply -f grafana.yaml
```
