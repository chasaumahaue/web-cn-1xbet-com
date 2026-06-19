<?php

class LinkCard
{
    private string $url;
    private string $keyword;
    private array $meta;

    public function __construct(string $url, string $keyword)
    {
        $this->url = $url;
        $this->keyword = $keyword;
        $this->meta = $this->generateMeta();
    }

    private function generateMeta(): array
    {
        return [
            'title' => $this->keyword . ' - 官方入口',
            'description' => '通过 ' . $this->keyword . ' 获取最新体育赛事与娱乐体验。',
            'favicon' => '/favicon.ico',
            'image' => '/images/' . strtolower(str_replace(' ', '-', $this->keyword)) . '-banner.png',
            'color' => '#1a73e8'
        ];
    }

    private function escapeHtml(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function buildStyle(): string
    {
        $color = $this->escapeHtml($this->meta['color']);
        return <<<CSS
        <style>
            .link-card {
                border: 1px solid #e0e0e0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                max-width: 480px;
                transition: box-shadow 0.2s;
            }
            .link-card:hover {
                box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            }
            .link-card-image {
                width: 100%;
                height: 180px;
                background-color: {$color};
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 1.5rem;
                font-weight: bold;
            }
            .link-card-body {
                padding: 16px 20px 20px 20px;
            }
            .link-card-title {
                font-size: 1.2rem;
                font-weight: 600;
                margin: 0 0 8px 0;
                color: #222;
            }
            .link-card-description {
                font-size: 0.9rem;
                color: #555;
                margin: 0 0 12px 0;
                line-height: 1.4;
            }
            .link-card-url {
                display: inline-block;
                font-size: 0.8rem;
                color: {$color};
                text-decoration: none;
                border-bottom: 1px solid transparent;
                transition: border-color 0.15s;
            }
            .link-card-url:hover {
                border-bottom-color: {$color};
            }
            .link-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px solid #f0f0f0;
            }
            .link-card-favicon {
                width: 20px;
                height: 20px;
                border-radius: 4px;
                margin-right: 8px;
                vertical-align: middle;
            }
        </style>
CSS;
    }

    public function render(): string
    {
        $url = $this->escapeHtml($this->url);
        $keyword = $this->escapeHtml($this->keyword);
        $title = $this->escapeHtml($this->meta['title']);
        $desc = $this->escapeHtml($this->meta['description']);
        $image = $this->escapeHtml($this->meta['image']);
        $favicon = $this->escapeHtml($this->meta['favicon']);

        $style = $this->buildStyle();

        return <<<HTML
{$style}
<div class="link-card">
    <div class="link-card-image">
        {$keyword}
    </div>
    <div class="link-card-body">
        <h3 class="link-card-title">{$title}</h3>
        <p class="link-card-description">{$desc}</p>
        <div class="link-card-footer">
            <div>
                <img class="link-card-favicon" src="{$favicon}" alt="" aria-hidden="true">
                <a class="link-card-url" href="{$url}" target="_blank" rel="noopener noreferrer">
                    {$url}
                </a>
            </div>
        </div>
    </div>
</div>
HTML;
    }
}

function renderLinkCard(string $url, string $keyword): string
{
    $card = new LinkCard($url, $keyword);
    return $card->render();
}