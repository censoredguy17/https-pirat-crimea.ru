<?php

namespace App\Http\Controllers;

use App\Models\Admin\CategoryModel;
use App\Models\Admin\ContentModel;
use App\Models\Admin\SliderModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Symfony\Component\Translation\t;

class MainController extends Controller
{

    public function index(): View
    {
        $this->data['metaTitle'] = 'Морские прогулки в Феодосии — Пиратский клуб «Логово Крыма»';
        $this->data['metaDescription'] = 'Отправьтесь в незабываемое морское путешествие вдоль берегов Крыма на настоящей пиратской шхуне. Экскурсии к Кара-Дагу, купание в открытом море и дух приключений в Феодосии. Бронируйте борт прямо сейчас!';
        $this->data['metaKeywords'] = generateKeywordsFromTitle($this->data['metaTitle']);
        $this->data['slider'] = SliderModel::with('images')->where('id',1)->firstOrFail();
        $this->data['services'] = ContentModel::where('category_id', 1)->with('mainImage')->limit(3)->get();
        $this->data['adverts'] = ContentModel::where('category_id', 2)->with('mainImage')->limit(3)->get();
        return view('main', $this->data);
    }

    public function category(string $slug = null): View
    {
        $category = $this->data['category'] = CategoryModel::where('slug', $slug)->first();
        $this->data['contents'] = ContentModel::where('category_id', $category->id)->where('is_published', 1)->with('mainImage')->get();

        $this->data['breadcrumbs'] = [
            ['title' => $category->name, 'url' => '/']
        ];

        $this->data['metaTitle'] = $category->name . ' в Феодосии — Пиратский клуб «Логово Крыма»';

        // Description: Составляем уникальное описание для категории
        $this->data['metaDescription'] = 'Заказывайте ' . mb_strtolower($category->name) . ' в Феодосии. ' .
            'Уникальные маршруты вдоль побережья Крыма, опытные капитаны и атмосфера настоящего пиратского приключения!';

        // Keywords: Генерируем из названия категории
        $this->data['metaKeywords'] = generateKeywordsFromTitle($this->data['metaTitle']);

        return view('category', $this->data);
    }

    public function content(string $slug = null): View
    {
        $content = $this->data['content'] = ContentModel::with('images')->with(['videos' => function($query) {
            $query->where('is_published', 1) // Только активные
            ->orderBy('sort_order', 'asc'); // По порядку
        }])->where('slug', $slug)->firstOrFail();
        $category = $this->data['category'] = CategoryModel::where('id', $this->data['content']->category_id)->first();
        $this->data['images'] = $this->data['content']->images;
        $this->data['videos'] = $this->data['content']->videos;

        $this->data['breadcrumbs'] = [
            ['title' => $category->name, 'url' => route('category', $category->slug)],
            ['title' => $content->listTitle, 'url' => '/'],
        ];

        $this->data['metaTitle'] = $content->title . ' — ' . $category->name . ' в Феодосии | Логово Пиратов';

        // Description: Берем кусок текста из описания или генерируем шаблон
        // Очищаем от тегов и берем первые 160 символов для безопасности
        $descriptionText = mb_substr(strip_tags($content->textTop), 0, 160);
        $this->data['metaDescription'] = $descriptionText ?: 'Подробная информация об услуге "' . $content->title . '" в Феодосии. Цены, фото, видео и онлайн-бронирование на официальном сайте.';

        // Keywords
        $this->data['metaKeywords'] = generateKeywordsFromTitle($this->data['metaTitle']);

        return view('content', $this->data);
    }

    public function gallery(): View
    {
        $this->data['breadcrumbs'] = [
            ['title' => 'Галлерея', 'url' => route('gallery')],
        ];
        $this->data['albums'] = ContentModel::where('category_id', 6)->with('mainImage')->get();

        $this->data['metaTitle'] = 'Галерея и фотоотчеты — Пиратский клуб «Логово Крыма»';

        // Description: Описание, богатое ключевыми словами для визуального поиска
        $this->data['metaDescription'] = 'Смотрите яркие фото и видео наших морских приключений в Феодосии. ' .
            'Атмосфера пиратских прогулок, виды на Кара-Даг и счастливые лица наших гостей в Крыму.';

        // Keywords: Добавляем специфические слова для галереи
        $this->data['metaKeywords'] = generateKeywordsFromTitle($this->data['metaTitle']) .
            ', фото феодосия, морские прогулки видео, крым фотоотчет, пиратская шхуна фото';

        return view('gallery', $this->data);
    }

    public function contacts(): View
    {
        $this->data['breadcrumbs'] = [
            ['title' => 'Контакты', 'url' => route('contacts')],
        ];

        $this->data['metaTitle'] = 'Контакты — Забронировать морскую прогулку в Феодосии | Логово Пиратов';

        // Description: Указываем основные данные, чтобы они были видны прямо в поиске
        $this->data['metaDescription'] = 'Свяжитесь с нами для заказа морских прогулок, рыбалки или аренды шхуны в Феодосии. ' .
            'Наш адрес, телефон, мессенджеры и карта проезда к причалу «Логово Пиратов».';

        // Keywords: Географические и сервисные запросы
        $this->data['metaKeywords'] = generateKeywordsFromTitle($this->data['metaTitle']) .
            ', телефон пиратский клуб, где находится логово пиратов, адрес причала феодосия, заказать катер крым';
        // ----------------

        return view('contacts', $this->data);
    }


}
