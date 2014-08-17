## 大量圖檔處理

內文不需一一填寫連結，採用 shortcode 方式，先找到主題編輯器裡面的 functions.php，放置下面 php 片段。 

```
function imgs_loop( $atts ) {
    extract( shortcode_atts( array(
        'num' => '1',
        'url' => 'http://127.0.0.1/img_NUM_.jpg',
    ), $atts, 'atts' ) );
	$rarrs=array();
	for($x=0;$x<(int)$num;$x++) {
	   $imgurl = str_replace("_NUM_", $x, $url);
     $rarrs[$x]=sprintf( '<div><h3>Index %1$d</h3>Img blah <b>%2$s</b> Blah... <a href="%3$s">IMG URL</a><BR/>Blah..Blah..</div>',
        $x,
        esc_url($imgurl),
        esc_url($imgurl)
      );
	}
  return join("",$rarrs);
}
add_shortcode( 'y12imgs', 'imgs_loop' );
```
ftp上傳圖檔之後，根據路徑內文產生十段圖檔圖文的範例。
```
[y12imgs url="http://yoursites.com/wp/content/img_NUM_.jpg" num="10"]
```

## 其他參考連結

[WordPress › Custom Content Shortcode « WordPress Plugins](https://wordpress.org/plugins/custom-content-shortcode/)

無法使用變數，針對wordpress資料庫查詢，非內文編排。
```
[loop x="10"]
    <img src="variable_here"/>
[/loop]
```

[WordPress › Shortcoder « WordPress Plugins](https://wordpress.org/plugins/shortcoder/)

