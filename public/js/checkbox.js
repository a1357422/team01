$(document).ready(function() {

    var currentDate = new Date().toLocaleDateString();
    // 檢查 LocalStorage 是否存在已儲存的狀態
    if (localStorage.getItem('checkboxStatus')) {
        // 取得 LocalStorage 值
        var checkboxStatus = localStorage.getItem('checkboxStatus');

        if (localStorage.getItem('savedDate') !== currentDate) {
            localStorage.clear();
            localStorage.setItem('savedDate',currentDate);
        }
        // 根據 LocalStorage 值設定複選框的狀態
        $('.checkbox').each(function() {
            var checkboxId = $(this).val();
            if (checkboxStatus.includes(checkboxId)) {
                $(this).prop('checked', true);
            }
        });
    }

    // 當複選框的狀態改變時，更新 LocalStorage
    $('.checkbox').change(function() {
        var checkboxStatus = [];

        // 獲取所有被選中的複選框的值
        $('.checkbox:checked').each(function() {
            checkboxStatus.push($(this).val());
        });

        // 將複選框的狀態存入 LocalStorage
        localStorage.setItem('checkboxStatus', checkboxStatus);
    });
});
