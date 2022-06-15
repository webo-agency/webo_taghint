{if $elements}
    <div class="h6 pt-1">
        {foreach from=$tag_hint_show item="tag_hint_show"}
            <a href="szukaj?controller=search&s={$tag_hint_show.name}">{$tag_hint_show.name}</a>
        {/foreach}
    </div>
{/if}