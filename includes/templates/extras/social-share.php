<div class="clearfix"></div>
<style>
    @import url("//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
    a.btn-social,
    .btn-social
    {
        border-radius: 50%;
        color: #ffffff !important;
        display: inline-block;
        height: 54px;
        line-height: 54px;
        margin: 8px 4px;
        text-align: center;
        text-decoration: none;
        transition: background-color .3s;
        webkit-transition: background-color .3s;
        width: 54px;
    }

    .btn-social .fa,.btn-social i
    {
        backface-visibility: hidden;
        moz-backface-visibility: hidden;
        ms-transform: scale(1);
        o-transform: scale(1);
        transform: scale(1);
        transition: all .25s;
        webkit-backface-visibility: hidden;
        webkit-transform: scale(1);
        webkit-transition: all .25s;
    }
    .btn-social:hover,.btn-social:focus
    {
        color: #fff;
        outline: none;
        text-decoration: none;
    }
    .btn-social:hover .fa,.btn-social:focus .fa,.btn-social:hover i,.btn-social:focus i
    {
        ms-transform: scale(1.3);
        o-transform: scale(1.3);
        transform: scale(1.3);
        webkit-transform: scale(1.3);
    }
    .btn-social.btn-xs
    {
        font-size: 11px;
        height: 32px;
        line-height: 32px;
        margin: 6px 2px;
        width: 32px;
        vertical-align: middle; 
    }
    .btn-social.btn-sm
    {
        font-size: 13px;
        height: 36px;
        line-height: 36px;
        margin: 6px 2px;
        width: 36px;
    }
    .btn-social.btn-lg
    {
        font-size: 22px;
        height: 72px;
        line-height: 40px;
        margin: 10px 6px;
        width: 72px;
    }

    .btn-facebook
    {
        background-color: #3b5998;
    }
    .btn-facebook:hover
    {
        background-color: #4c70ba;
    }
    .btn-google-plus
    {
        background-color: #dd4b39;
    }
    .btn-google-plus:hover
    {
        background-color: #e47365;
    }
    .btn-twitter
    {
        background-color: #55acee;
    }
    .btn-twitter:hover
    {
        background-color: #83c3f3;
    }
    .share-buttons-container{
        padding-left: 4px;
        margin-top: 10px;
        margin-bottom: -15px;
        background: #FBFCFC;
    }
    .share-w{
        font-size: 12px;
        font-family: Inherit;
        font-weight: 400;
        font-style: normal;
        color: #444;
    }
</style>
    <div class="share-buttons-container">
        <div class="col-md-12 row">
            <span class='share-w'>share </span> 
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank" class="btn-social btn-xs btn-facebook"><i class="fa fa-facebook"></i></a>
            <a href="https://plus.google.com/share?url=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank" class="btn-social btn-xs btn-google-plus"><i class="fa fa-google-plus"></i></a>
            <a href="http://twitter.com/share?text=<?php echo the_title(); ?> Coupon&url=<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" target="_blank" class="btn-social btn-xs btn-twitter"><i class="fa fa-twitter"></i></a>
        </div>
    </div>