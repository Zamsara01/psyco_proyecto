<?php
/**
 * Interface for oEmbed providers
 */
interface OEmbedProviderInterface
{
    /**
     * Checks if the provider supports the given URL.
     *
     * @param string $url
     * @return bool
     */
    public function supports(string $url): bool;

    /**
     * Fetches the oEmbed data for the given URL.
     *
     * @param string $url
     * @return OEmbedDTO
     * @throws Exception if fetching or parsing fails.
     */
    public function fetch(string $url): OEmbedDTO;
}
