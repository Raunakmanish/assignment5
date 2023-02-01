module('Component', {
    setup: function(){
        this.component = $('<div class="input-append date" id="datetimepicker">'+
                                '<input size="16" type="text" value="12-02-2012" readonly>'+
                                '<span class="add-on"><i class="icon-th"></i></span>'+
                            '</div>')
                        .appendTo('#qunit-fixture')
                        .datetimepicker({format: "dd-mm-yyyy", viewSelect: 2});
        this.input = this.component.find('input');
        this.addon = this.component.find('.add-on');
        this.dp = this.component.data('datetimepicker')
        this.picker = this.dp.picker;
    },
    teardown: function(){
        this.picker.remove();
    }
});


test('Component gets date/viewDate from input value', function(){
    datesEqual(this.dp.date, UTCDate(2012, 1, 12));
    datesEqual(this.dp.viewDate, UTCDate(2012, 1, 12));
});

test('Activation by component', function(){
    ok(!this.picker.is(':visible'));
    this.addon.click();
    ok(this.picker.is(':visible'));
});

test('simple keyboard nav test', function(){
    var target;

    // Keyboard nav only works with non-readonly inputs
    this.input.removeAttr('readonly');

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'February 2012', 'Title is "February 2012"');
    datesEqual(this.dp.date, UTCDate(2012, 1, 12));
    datesEqual(this.dp.viewDate, UTCDate(2012, 1, 12));

    // Focus/open
    this.addon.click();

    // Navigation: -1 day, left arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 37
    });
    datesEqual(this.dp.viewDate, UTCDate(2012, 1, 11));
    datesEqual(this.dp.date, UTCDate(2012, 1, 11));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'February 2012', 'Title is "February 2012"');

    // Navigation: +1 month, shift + right arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 39,
        shiftKey: true
    });
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 11));
    datesEqual(this.dp.date, UTCDate(2012, 2, 11));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 year, ctrl + left arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 37,
        ctrlKey: true
    });
    datesEqual(this.dp.viewDate, UTCDate(2011, 2, 11));
    datesEqual(this.dp.date, UTCDate(2011, 2, 11));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2011', 'Title is "March 2011"');
});

test('setValue', function(){
    this.dp.date = UTCDate(2012, 2, 13)
    this.dp.setValue()
    datesEqual(this.dp.date, UTCDate(2012, 2, 13));
    equal(this.input.val(), '13-03-2012');
});

test('update', function(){
    this.input.val('13-03-2012');
    this.dp.update()
    datesEqual(this.dp.date, UTCDate(2012, 2, 13));
});

test('Navigating to/from decade view', function(){
    var target;

    this.addon.click();
    this.input.val('31-03-2012');
    this.dp.update();

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    ok(target.is(':visible'), 'View switcher is visible');

    target.click();
    ok(this.picker.find('.datetimepicker-months').is(':visible'), 'Month picker is visible');
    equal(this.dp.viewMode, 3);
    // Not modified when switching modes
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 31));
    datesEqual(this.dp.date, UTCDate(2012, 2, 31));

    target = this.picker.find('.datetimepicker-months thead th.switch');
    ok(target.is(':visible'), 'View switcher is visible');

    target.click();
    ok(this.picker.find('.datetimepicker-years').is(':visible'), 'Year picker is visible');
    equal(this.dp.viewMode, 4);
    // Not modified when switching modes
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 31));
    datesEqual(this.dp.date,�,�Ћ i�        META:https://www.easeus.com�ئ���;*_https://www.easeus.com gr_imp_-727854849){"expiredAt":1625645602733,"value":true}$�^gk�        8META:chrome-extension://pkedcjkdefgpdelpbcmbmeomcjbeemfm��������H_chrome-extension://pkedcjkdefgpdelpbcmbmeomcjbeemfm mr.temp.LogManager��["[2021-07-06 11:47:10.76][INFO][mr.Init] MR instance ID: 4cad0510-bbb2-4a2c-a747-38176bd421d1\n","[2021-07-06 11:47:10.76][INFO][mr.Init] Native Cast MRP is enabled.\n","[2021-07-06 11:47:10.76][INFO][mr.Init] Native Mirroring Service is enabled.\n","[2021-07-06 11:47:10.77][INFO][mr.PersistentDataManager] removeTemporary_: 180 chars used\n","[2021-07-06 11:47:10.77][INFO][mr.PersistentDataManager] initialize: 180 chars used, 67 other chars\n","[2021-07-06 11:47:10.77][INFO][mr.CloudProvider] Initializing Cloud MRP\n","[2021-07-06 11:47:10.77][INFO][mr.CloudProvider] Cloud enabled setting: false\n","[2021-07-06 11:47:11.85][INFO][mr.CloudProvider] Privacy notified setting: false\n","[2021-07-06 11:47:29.31][INFO][mr.PersistentDataManager] onSuspend\n","[2021-07-06 11:47:43.91][INFO][mr.PersistentDataManager] onSuspend\n","[2021-07-06 11:47:54.92][INFO][mr.PersistentDataManager] onSuspend\n","[2021-07-06 11:48:08.75][INFO][mr.PersistentDataManager] o