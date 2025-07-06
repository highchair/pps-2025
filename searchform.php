<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <label>
    <span class="sr">Search for:</span>
    <input type="search" class="search-field" placeholder="Search …" value="<?php echo get_search_query() ?>" name="s" />
  </label>
  <input type="submit" class="search-submit btn__secondary" value="Search" />
</form>