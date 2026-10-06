<form role="search" method="get" id="searchform" class="search-form" action="<?php echo home_url('/'); ?>">
  <label for="s"></label>
  <input type="search" value="<?php echo get_search_query(); ?>" name="s" id="s"  />
  <button type="submit" id="searchsubmit" class="search-submit">Search</button>
</form>