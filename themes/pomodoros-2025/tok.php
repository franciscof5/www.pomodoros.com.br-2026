<?php
/* Template Name: toker */
get_header();

//var_dump(Jwt_Auth);
echo $token = $_GET['t'];
$token2 = JWT::decode(
    $token,
    new Key($secret_key, apply_filters('jwt_auth_algorithm', 'HS256'))
);
var_dump($token2->data->user->id);
?>
<?php
get_footer();
?>
