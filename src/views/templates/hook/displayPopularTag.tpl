{if $displayedTag}
    <div class="h6 pt-1">
        {foreach from=$displayedTag item="tag_hint_show"}
            <a href="szukaj?controller=search&s={$tag_hint_show}">{$tag_hint_show}</a>
        {/foreach}
    </div>
{/if}