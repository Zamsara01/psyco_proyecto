<?php
/**
 * DTO (Data Transfer Object) for standardized oEmbed responses.
 */
class OEmbedDTO implements JsonSerializable
{
    public string $title;
    public string $provider_name;
    public string $provider_url;
    public string $html;
    public int $width;
    public int $height;
    
    public ?string $author_name;
    public ?string $author_url;
    public ?string $thumbnail_url;
    public ?int $thumbnail_width;
    public ?int $thumbnail_height;
    
    // Original raw response from provider (optional)
    public ?array $raw_data;

    public function __construct(
        string $title,
        string $provider_name,
        string $provider_url,
        string $html,
        int $width,
        int $height,
        ?string $author_name = null,
        ?string $author_url = null,
        ?string $thumbnail_url = null,
        ?int $thumbnail_width = null,
        ?int $thumbnail_height = null,
        ?array $raw_data = null
    ) {
        $this->title = $title;
        $this->provider_name = $provider_name;
        $this->provider_url = $provider_url;
        $this->html = $html;
        $this->width = $width;
        $this->height = $height;
        $this->author_name = $author_name;
        $this->author_url = $author_url;
        $this->thumbnail_url = $thumbnail_url;
        $this->thumbnail_width = $thumbnail_width;
        $this->thumbnail_height = $thumbnail_height;
        $this->raw_data = $raw_data;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'provider_name' => $this->provider_name,
            'provider_url' => $this->provider_url,
            'html' => $this->html,
            'width' => $this->width,
            'height' => $this->height,
            'author_name' => $this->author_name,
            'author_url' => $this->author_url,
            'thumbnail_url' => $this->thumbnail_url,
            'thumbnail_width' => $this->thumbnail_width,
            'thumbnail_height' => $this->thumbnail_height,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
