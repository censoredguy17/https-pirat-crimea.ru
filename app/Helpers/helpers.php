<?php

if (!function_exists('generateKeywordsFromTitle')) {
    /**
     * Генерирует строку ключевых слов из заголовка.
     */
    function generateKeywordsFromTitle($title, $limit = 10) {
        $title = mb_strtolower($title, 'UTF-8');
        $title = preg_replace('/[^\w\s\d]/u', ' ', $title);
        $words = preg_split('/\s+/u', $title, -1, PREG_SPLIT_NO_EMPTY);

        $stopWords = ['и', 'в', 'во', 'не', 'на', 'с', 'со', 'как', 'а', 'то', 'все', 'для', 'что', 'это'];

        $filteredWords = array_filter($words, function($word) use ($stopWords) {
            return !in_array($word, $stopWords) && mb_strlen($word, 'UTF-8') > 2;
        });

        $uniqueWords = array_unique($filteredWords);
        return implode(', ', array_slice($uniqueWords, 0, $limit));
    }
}

if (!function_exists('smart_preview')) {
    /**
     * Безопасно обрезает HTML до нужного количества символов.
     */
    function smart_preview($html, $limit = 600) {
        if (mb_strlen(strip_tags($html)) <= $limit) {
            return ['is_long' => false, 'full' => $html];
        }

        // Обрезаем строку
        $truncated = mb_substr($html, 0, $limit);

        // Чтобы не закрывать теги вручную, используем DOMDocument
        // Он автоматически закроет все открытые <div>, <p> и т.д.
        $doc = new DOMDocument();
        // Подавляем ошибки из-за "неполного" HTML
        @$doc->loadHTML(mb_convert_encoding($truncated . '...', 'HTML-ENTITIES', 'UTF-8'));
        $preview = $doc->saveHTML();

        return [
            'is_long' => true,
            'preview' => $preview,
            'full'    => $html
        ];
    }
}
