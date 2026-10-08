<?php
#date_default_timezone_set('America/Sao_Paulo');

// Get current page's URL
$pageUrl = get_page_link(get_the_ID());
$pageUrl = "https://www.pomodoros.com.br/calendar";
// Links for calendar years
$yearsLinks = array();

$query_string_t  = explode('calendario=', $_SERVER['REQUEST_URI']);
$query_string_t2  = explode('&', $query_string_t[1]);
$query_string_t2 = $query_string_t2[0];
if($query_string_t2!="") {
    $calendario_selected = "&calendario=".$query_string_t2;
}

// Loop through list of years to display link for each year
foreach ($years as $yearDetails)
{
    $queryArguments = array('calendar_year' => $yearDetails->year);
    if ($category) : $queryArguments['category'] = $category; endif;
    //$yearsLinks[] = '<a href="' . get_bloginfo('url')."/calendar/&calendar_year=".$yearDetails->year. '">'. $yearDetails->year . '</a>';
    if($yearDetails->year==2012)
    $yearsLinks[] = '<a href="' . add_query_arg($queryArguments, $pageUrl) . $calendario_selected . '">' . $yearDetails->year . '</a>';
    elseif($yearDetails->year>2012)
    $yearsLinks[] = '<a href="' . add_query_arg($queryArguments, $pageUrl) . $calendario_selected . '">' . $yearDetails->year . '</a> |';
}
?>

<p class="calendar-p col-md-12 DDDhidde-sm DDDhidde-xs">
<?php
// Output links for calendar years
printf(__('Ver anos anteriores: %s', 'ranking-calendar'), implode(' ', $yearsLinks));
?>
</p>
<p class="calendar-p DDDhidde-sm DDDhidde-xs">
<?php if(is_user_logged_in()) {
    $query_string_s  = explode('calendar_year=', $_SERVER['REQUEST_URI']);
    $query_string_s[1];
    $query_string_s2  = explode('&', $query_string_s[1]);
    $query_string_s2 = $query_string_s2[0];
    if(isset($query_string_s2)) {
        $year_selected = get_bloginfo('url')."/calendar/&calendar_year=".$query_string_s2;
    }
     ?>
	visualizar calendario: <a href="<?php bloginfo('url'); ?>/calendar/?calendario=pessoal<?php echo $year_selected ?>">pessoal</a> | <a href="<?php bloginfo('url'); ?>/calendar/?calendario=comunidade<?php echo $year_selected ?>">comunidade</a> | <a href="<?php bloginfo('url'); ?>/calendar/?calendario=agregado<?php echo $year_selected ?>">completo</a>
<?php } else { ?>

<?php } ?>
</p>
<?php
// Current month and year
$currentMonth = date('n');
$currentYear = date('Y');

// First day of week to use
$firstDayOfWeek = (int)$options['first_day_of_week'];

// Setting flag 'hide no posts months'
$hideNoPostsMonths = (bool)$options['hide_no_posts_months'];

// Setting flag 'reverse months'
$reverseMonths = (bool)$options['reverse_months'];

// Initialize needed flag
$showFutureMonths = false;

// Setting flag 'show future posts'
$showFuturePosts = (bool)$options['show_future_posts'];

// Weekdays
$weekdays = array
(
    __('Domingo', 'ranking-calendar')
    , __('Segunda', 'ranking-calendar')
    , __('Terça-feira', 'ranking-calendar')
    , __('Quarta-feira', 'ranking-calendar')
    , __('Quinta-feira', 'ranking-calendar')
    , __('Sexta-feira', 'ranking-calendar')
    , __('Sábado', 'ranking-calendar')
);

// Loop through months to display calendar with posts
for ($month = ($reverseMonths ? 12 : 1); ($reverseMonths ? 0 < $month : 12 >= $month); ($reverseMonths ? $month-- : $month++))
{
    /**
     * Move to next month if any of the following matches
     * - If 'hide no posts months' setting flag is ON and there are no posts for current month in current year
     * - If 'hide no posts months' and 'show future posts' setting flags are OFF and current month-year is in future
     */
    if ($hideNoPostsMonths)
    {
        if (!isset($postsPerDay[$month]))
        {
            continue;
        }
    }
    else if (!$hideNoPostsMonths && $currentYear <= $year && $currentMonth < $month)
    {
        if (isset($postsPerDay[$month]))
        {
            $showFutureMonths = true;
        }

        if (!$showFuturePosts || !$showFutureMonths)
        {
            continue;
        }
    }

    // Time for first day of current month/year
    #date_default_timezone_set('America/Sao_Paulo');
    $timeForFirstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

    // Include needed layout
    #include('calendar-layout-' . $layout . '.php');
	#var_dump("PASSO1");
    if($month < $currentMonth)
    echo '<div class="DDDhidde-sm DDDhidde-xs">';
    include('ranking-calendar-layout-bootstrap.php');
    if($month < $currentMonth)
    echo '</div>';
}

// Include needed javascript only when 'browse by month' setting is ON
if ((bool)$options['browse_by_month'])
{
?>
<!--script src="<?php echo get_option('siteurl'); ?>/wp-includes/js/jquery/jquery.js" type="text/javascript"></script-->
<script src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/ranking-calendar/views/ranking-calendar-display.js" type="text/javascript"></script>


<?php
}

