
$(document).ready(function(){
    // Sử dụng đường dẫn tương đối từ gốc website
    var strurl = base_url + "search/quick"; 
    
    $("#txtsearch").keyup(function(){
        var key = $(this).val();
        if(key == ""){
            $(".search-quick").css("display","none");
        } else {
            $.ajax({
                url: strurl,
                type: "GET",
                data: { keyword: key },
                success: function(kq){
                    $(".search-quick").html(kq);
                    $(".search-quick").css("display","block");
                }
            });
        }
    });
});