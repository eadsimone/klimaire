$jq(document).ready(function() {

    $jq('#datepicker-example1').Zebra_DatePicker();

    $jq('#datepicker-example2').Zebra_DatePicker({
        direction: 1    // boolean true would've made the date picker future only
                        // but starting from today, rather than tomorrow
    });

    $jq('#datepicker-example3').Zebra_DatePicker({
        direction: true,
        disabled_dates: ['* * * 0,6']   // all days, all monts, all years as long
                                        // as the weekday is 0 or 6 (Sunday or Saturday)
    });

    $jq('#datepicker-example4').Zebra_DatePicker({
        direction: [1, 10]
    });

    $jq('#datepicker-example5').Zebra_DatePicker({
        format: 'M d, Y'
    });

    $jq('#datepicker-example6').Zebra_DatePicker({
        show_week_number: 'Wk'
    });

    $jq('#datepicker-example7').Zebra_DatePicker({
        view: 'years'
    });

});