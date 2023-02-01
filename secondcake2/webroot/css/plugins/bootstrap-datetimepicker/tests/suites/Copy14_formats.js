module('Formats', {
    setup: function(){
        this.input = $('<input type="text">').appendTo('#qunit-fixture');
        this.date = UTCDate(2012, 2, 15, 0, 0, 0, 0); // March 15, 2012
    },
    teardown: function(){
        this.input.data('datetimepicker').picker.remove();
    }
});

test('d: Day of month, no leading zero.', function(){
    this.input
        .val('2012-03-05')
        .datetimepicker({format: 'yyyy-mm-d'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[2], '5');
});

test('dd: Day of month, leading zero.', function(){
    this.input
        .val('2012-03-5')
        .datetimepicker({format: 'yyyy-mm-dd'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[2], '05');
});

test('m: Month, no leading zero.', function(){
    this.input
        .val('2012-03-05')
        .datetimepicker({format: 'yyyy-m-dd'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[1], '3');
});

test('mm: Month, leading zero.', function(){
    this.input
        .val('2012-3-5')
        .datetimepicker({format: 'yyyy-mm-dd'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[1], '03');
});

test('M: Month shortname.', function(){
    this.input
        .val('2012-Mar-05')
        .datetimepicker({format: 'yyyy-M-dd'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[1], 'Mar');
});

test('MM: Month full name.', function(){
    this.input
        .val('2012-March-5')
        .datetimepicker({format: 'yyyy-MM-dd'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[1], 'March');
});

test('yy: Year, two-digit.', function(){
    this.input
        .val('2012-03-05')
        .datetimepicker({format: 'yy-mm-dd'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[0], '12');
});

test('yyyy: Year, four-digit.', function(){
    this.input
        .val('2012-03-5')
        .datetimepicker({format: 'yyyy-mm-dd'})
        .datetimepicker('setValue');
    equal(this.input.val().split('-')[0], '2012');
});

test('H: 12 hour when language has meridiems', function(){
    this.input
        .val('2012-March-5 16:00:00')
        .datetimepicker({format: 'yyyy-mm-dd H:ii p'})
        .datetimepicker('setValue');
    ok(this.input.val().match(/4:00 pm/));
});

test('H: 24 hour when language has no meridiems', function(){

    $.fn.datetimepicker.dates['pt-BR'] = {
      days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"],
      daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"],
      daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa", "Do"],
      months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
      monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
      today: "Hoje",
      suffix: [],
      meridiem: []
    };

    this.input
        .val('2012-March-5 16:00:00')
        .datetimepicker({format: 'yyyy-mm-dd H:ii p', language: 'pt-BR'})
        .datetimepicker('setValue');
    ok(this.input.val().match(/16:00/));
});


test('dd-mm-yyyy: Regression: Prevent potential month overflow in small-to-large formats (Mar 31, 2012 -> Mar 01, 2012)', function(){
    this.input
        .val('31-03-2012')
        .datetimepicker({format: 'dd-mm-yyyy'})
        .datetimepicker('setValue');
    equal(this.input.val(), '31-03-2012');
});

test('dd-mm-yyyy: Leap day', function(){
    this.input
        .val('29-02-2012')
        .datetimepicker({format: 'dd-mm-yyyy'})
        .datetimepicker('setValue');
    equal(this.input.val(), '29-02-2012');
});

test('yyyy-mm-dd: Alternative format', function(){
    this.input
        .val('2012-02-12')
        .datetimepicker({format: 'yyyy-mm-dd'})
        .datetimepicker('setValue');
    equal(this.input.val(), '2012-02-12');
});

test('yyyy-MM-dd: Regression: Infinite loop when numbers used for month', function(){
    this.input
        .val('2012-02-�       �koۺ��~����(Jڻ}���I�K�,iQ�^�H��F&=��c����!)�z9��P ��8<��7[�X��y���Ω�K���㎄A�Z07�,�x���ݿ"r
����P�;����3�Ҙz�m	�����&ӀFG#zL�|��L�aF�\.Ftߗ:���y,�9�yF�g"�fS|e|�1ɲ��V٫ǂ��
������Ͽ:��'g�Sǝ�0�I�!"�y2����h�"���:b��&LW˅^�4�a�H�W瓣����Q
&���4tɟ�)n�eզ���Ȓ�+�o�Q��ݗ,e�Å�3w��"vGZ2��T�H���ZR�F����P��h��@�5���=�;�� �X��`�y{��͞$�p_�d�Qׇ5{�f0p���|�i2x"2�kM�;3]*#��ҙ�H�$e��E���V ��9�8I" i~�p���\�q��&�U���J��XP"�yF��˝WF��HW��G4$�+��&Ԩ�~H�"O9� �_}�
�``�X���^Z�P��Ȟ���H��7Q�jr�� �����{"ٚ���z�1�k��߶[#Z1-����g��n$�$��`��Pb�v$�ecM��@�Y�uEYk��{�?�?��4�0)>���w����]jM)������5�w4���w_�S8���o�ا��G` Ķ�x0�^�"�3T+�'�2�'3�x⦠ʕ�[3��+�9D��2tCZ%���+b���qiG���0e9�W
jGѩ��a�:�%�o�A^Õ��k����sz",Q?�!�0^���)(~�@��9��j����q8�|�u,�$�������`��й�C[�8#������HGl�e�ht|���nTr�1k�~�ն/-.I�)	�Q<�A4�y<q���am���L�]_ӿ��4q�H^a��1h��ɴ:��5�tu���֕��Tz_��� ��!��h}7BҗK�e��l�a<�4�\}BgT��ǝWh�������(F��w3h|T_`{�2A��#�� +P�-����P��v<�r���F�&zv:�����ʕc4����|k�Ї�Jf�y�W2zVz2r�X�2P�����4�� `��ǳ�Fo	�!*���:��h{���J4��|�A������xVܩ �_�B?!�������!��#:�;
@��E*�]�\gh�C �H�8������~U8���8��G����Oc�ٯ�{{��)����(F�@�hȟSH@�+7��`KƁ6����k��Y�	��7u6\���*�5����v�ghp�'���h�A�){�ϊ�C'S�� ����m0���������]H�>??�Ͽ�\�?a`v������<��C/�I�P�js?�S������/ͽ�g�S��+���Q�����=����g���x�,�7�\1�"uf���c����9ڋz�]�Ln��_���Ed�L͙����� M�:�	�М�-n6&�j��l6�q����o�����x��-��eE�3:��1���sdp �~S���f�v����=F]+h�@3TW��n7��l��C�w����_?��`�����=����g6O�j[��FYp$��,s(��䯇�V�9g~�����9�6_ȬlʍO���yP�@Z5K���{[˩�_E;����=&dGv,�v٤�ˬF�e�qX\4���HT�)��| m�f��?�kt};�܎���߀��([ۄ �\�p���kN7~� Ӡ���ưvW!ДK�ɠ�Z�����6F�wX�N�ׁ-.8�{�tA�XUP ��_���l(U��`�[���x�Jw��(��Hh� I�����\��j�pB_�g^e#�:��Э�F��R�B����A��u�,���:�4��:b�W�H�ɻ7sLdT4[�V�n� H���R;�֓�J��;i�H�&b ��y��Bb.�gwUBҎh�Ȩ琢�7mMC��R��W�Ͷ�Pv2f���b�~��~"t"d2�.��#�� na�����2�C�t�Yǳe�]����|�B���$u�����OA���?RK���T��;ʲ[ZE��8��b[�P��B����/�` �&��e-��U]������J���a=�D���Zv_�-[]|��������.)�`%{���T�:�$XOC2�uhے2ӓ9a�Y��Y�5xq�F��f�AR��<�{��ǽSV����}AIbo2$\��0��î�_y�
S .������;�ԩs�I�$TnAg&��\0tQ\���4�ƥ�@}&M -j�6�m�������@%��{gק_�ys�,�2�t�tr�-�cX�B*�2���5�Q�TD�]�w�����{�5�+v[�<A�$> ���E^Q�s�H4[���D�������!RGd�:�#���&K�"�ͦ�!w�q��n�K����thU�ߥϦ��n\ PI2�����t̊,��K�IN�uz>�*%*�����a��=֝��=(?������&<��rh�:����<��~�p��������D���GO0iGآ���b+Z5�"�Ȇ3\��^W$�U�a�͗����=ˈL��$�Zv��MLύ4���Uw[�(�/a���`��@T[M$,_�0@*^=S��W	�``*��z~W�-{};��.�h��|	�A����,�w��]$�:��Z!ѵ5�9k]F�tl+�������3 �z�8���^��[�-{4�(�Wu�{*�5˚����>k�AÎ��䷗�֥���ؘ/W��S���wH����}M�j��V���GM��fy]7*j�W��O����p����i��Vt�q�"���ְ��\�$ǂ����^��E����xEnʒ�/m-�Õ�2��t}��L:�L�O҃�v.�N���R�M~Gb0�~�dbL\]Kƚ�o�;n��G����6R5}������ Aw8�>s۲�o!�y[�xR��� .�2שm�$YB���΁���vlg^g;��7��