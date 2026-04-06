#!/bin/bash

echo "🚀 [1/4] Собираем стили и скрипты (Vite)..."
npm run build

echo "📦 [2/4] Добавляем изменения в Git..."
git add .

echo "📝 [3/4] Создаем коммит..."
# Спрашиваем описание коммита
echo "Что изменили? (например: fixed gallery):"
read msg
if [ -z "$msg" ]; then
    msg="Minor updates"
fi
git commit -m "$msg"

echo "☁️ [4/4] Отправляем на GitHub..."
git push origin main

echo "✅ ПОБЕДА! Теперь на сервере напиши: ./pull.sh"
