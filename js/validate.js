$(document).ready(function() {

    $('#submit_form').validate({
        rules: {
            car_type: {
              required: true
            },
            frame_number :{
              required: true
            },
            out_color_name :{
              required: true
            },
            sale_price :{
              required: true,
              number: true
            },
            shift_cnt : {
              number :true
            }
          },
          messages: {
            car_type: {
              required: "型式が必須です。"
            },
            frame_number :{
              required: "車台番号が必須です。"
            },
            out_color_name :{
              required: "外装色が必須です。"
            },
            sale_price :{
              required: "小売価格が必須です。",
              number: "数値を入力して下さい。"
            },
            shift_cnt : {
              number: "数値を入力して下さい。"
            }
          },
    });

});