// map.js

document.addEventListener('DOMContentLoaded', function() {
    // 現在開かれているポップオーバーを保持するための変数
    var currentPopover = null;

    // 各県ごとにポップオーバーを有効にする
    document.querySelectorAll('.area div').forEach(function(element) {
        // 各県のIDを取得
        var prefectureId = element.id;

        // Bootstrap Popoverのオプションを設定
        var popoverOptions = {
            container: 'body',
            toggle: 'popover',
            placement: 'top',
            content: getPopoverContent(prefectureId),
            title: prefectureId,
            trigger: 'click'
        };

        // Bootstrap Popoverを初期化
        var popover = new bootstrap.Popover(element, popoverOptions);

        // クリックイベントを追加して、新しいポップオーバーが表示される前に
        // 現在開かれているポップオーバーを閉じる
        element.addEventListener('click', function() {
            if (currentPopover) {
                currentPopover.hide();
            }
            currentPopover = popover;
        });
    });

    // 各県に対応するポップアップの内容を取得する関数
    function getPopoverContent(prefectureId) {
        // ここで各県ごとの内容を返す
        switch (prefectureId) {
        // 北海道
        case 'hokkaido':
            return 'ジンギスカン';
        // 東北地方
        // 青森県
        case 'aomori':
            return 'りんご、青森ねぶた祭りの屋台飯';
        // 岩手県
        case 'iwate':
            return 'じゃじゃ麺、わんこそば';
        // 宮城県
        case 'miyagi':
            return '牛たん、伊達巻';
        // 秋田県
        case 'akita':
            return 'きりたんぽ、なまはげ鍋';
        // 山形県
        case 'yamagata':
            return '蔵王そば、芋煮';
        // 福島県
        case 'fukushima':
                return '会津のそば、会津のまんじゅう';
        // 愛知県
        case 'aichi':
            return '名古屋めし、味噌カツ';
        // 岐阜県
        case 'gifu':
            return '岐阜和牛、郡上ダンゴ';
        // 静岡県
        case 'shizuoka':
            return '清水焼、お茶';
        // 三重県
        case 'mie':
            return '伊勢うどん、伊勢海老';
        // 長野県
        case 'nagano':
            return '信州そば、りんご';
        // 富山県
        case 'toyama':
            return '富山ブラック、ういろう';
        // 石川県
        case 'ishikawa':
            return '加賀漬、金沢カレー';
        // 福井県
        case 'fukui':
            return '越前ガニ、若狭塗';
        // 新潟県
        case 'niigata':
            return '新潟の海の幸、山の幸';
        // 山梨県
        case 'yamanashi':
            return 'ほうとう、ほうじ茶';
        // 東京都
        case 'tokyo':
            return '寿司、もんじゃ焼き、おでん';
        // 神奈川県
        case 'kanagawa':
            return 'しょうが焼き、横浜ラーメン、さんま寿司';
        // 千葉県
        case 'chiba':
            return 'ひつまぶし、かんぴょう巻き、房総の潮騒丼';
        // 埼玉県
        case 'saitama':
            return 'ほうとう、川越しらたき、浦和焼きそば';
        // 茨城県
        case 'ibaraki':
            return '水戸の納豆、霞ヶ浦の鮒寿司、筑波山のうなぎ';
        // 栃木県
        case 'tochigi':
            return 'とちぎ餃子、宇都宮焼きそば、栃木名物キンピラゴボウ';
        // 群馬県
        case 'gunma':
                return 'おんどり鍋、たたきごぼう、上毛三大餃子';
        // 滋賀県
        case 'shiga':
            return '近江牛、ひこうき寿司';
        // 京都府
        case 'kyoto':
            return '京都懐石料理、伝統的な京料理';
        // 大阪府
        case 'osaka':
            return 'お好み焼き、たこ焼き';
        // 兵庫県
        case 'hyougo':
            return '神戸牛、明石焼き';
        // 奈良県
        case 'nara':
            return '和牛、吉野そば';
        // 和歌山県
        case 'wakayama':
            return 'ふぐ料理、和歌山ラーメン';
        
        // 鳥取県
        case 'tottori':
            return 'かんぴょう巻き、砂丘で有名な地域';
        // 島根県
        case 'shimane':
            return '出雲そば、石見銀山が観光地';
        // 岡山県
        case 'okayama':
            return 'もも、岡山風傘が有名';
        // 広島県
        case 'hiroshima':
            return '広島風お好み焼き、もみじ饅頭';
        // 山口県
        case 'yamaguchi':
            return 'ふぐ料理、萩焼が名物';
        // 香川県
        case 'kagawa':
            return '讃岐うどん、小豆島のオリーブ';
        // 徳島県
        case 'tokushima':
            return '阿波おどり、南国市の鳴門金時';
        // 愛媛県
        case 'ehime':
            return '伊予柑、道後温泉';
        // 高知県
        case 'kouchi':
            return '土佐料理、龍馬がゆく観光スポット';
            
        // 福岡県
        case 'fukuoka':
            return 'もつ鍋、博多ラーメン';
        // 佐賀県
        case 'saga':
            return '有田焼、佐賀牛';
        // 長崎県
        case 'nagasaki':
            return '長崎ちゃんぽん、カステラ';
        // 熊本県
        case 'kumamoto':
            return '馬刺し、熊本城';
        // 大分県
        case 'oita':
            return '刺身鍋、由布院温泉';
        // 宮崎県
        case 'miyazaki':
            return 'チキン南蛮、青島ビール';
        // 鹿児島県
        case 'kagoshima':
            return 'さつま揚げ、桜島';
        // 沖縄県
        case 'okinawa':
            return 'ゴーヤーチャンプルー、首里城跡';
        
        default:
            return 'デフォルトの情報';
        }
    }
});
