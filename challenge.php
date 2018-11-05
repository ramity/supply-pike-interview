<?php

//Assuming array input/file to array conversion done elsewhere
$bookingInput = [
    [0, 10],
    [30, 40],
    [106, 106],
    [100, 120],
    [90, 110],
    [105, 110],
    [340, 360]
];

//Initialize calendar booking output array
// - PHP cannot (atleast to what I'm aware of) initialize an array with a predefined
// - size/value but this shall suffice. If I were to do the above in another
// - language, I would initialize the array size 365 elements initialized to 0.
$bookings = array_fill(0, 366, 0);
$topBookedDays = [0, 0, 0];

//iterate over each booking as given
foreach($bookingInput as $bookingEntry)
{
    $startDay = $bookingEntry[0];
    $endDay = $bookingEntry[1];

    for($day = $startDay;$day <= $endDay;$day++)
    {
        //increment the booking for this day
        $bookings[$day]++;
    }
}

//Determine top 3 booked days
// - It is more efficient to provide an additional foreach loop to find the
// - 3 top values rather than query with a conditional nested inside the
// - foreach + for loop above
foreach($bookings as $day => $booking)
{
    if($booking > $bookings[$topBookedDays[0]])
    {
        //shift array to the right
        $topBookedDays[2] = $topBookedDays[1];
        $topBookedDays[1] = $topBookedDays[0];
        $topBookedDays[0] = $day;
    }
    elseif($booking > $bookings[$topBookedDays[1]])
    {
        $topBookedDays[2] = $topBookedDays[1];
        $topBookedDays[1] = $day;
    }
    elseif($booking > $bookings[$topBookedDays[2]])
    {
        $topBookedDays[2] = $day;
    }
}

//Now that we have all the data populated, we can start outputing results to the user
echo "All available: [";

$start = false;

//Display ranges of available booking days
foreach($bookings as $day => $booking)
{
    if($booking == 0 && $start == false)
    {
        $start = $day;
    }
    elseif($booking == 1 && $start !== false)
    {
        $end = $day - 1;

        echo "({$start}, {$end}),";

        $start = false;
    }
    elseif($day == 365)
    {
        $end = $day;

        echo "({$start}, {$end})]\n";

        $start = false;
    }
}


echo "Most: {$topBookedDays[0]} ({$bookings[$topBookedDays[0]]} bookings)\n";
echo "Top-3: {$topBookedDays[0]} ({$bookings[$topBookedDays[0]]}), "
           ."{$topBookedDays[1]} ({$bookings[$topBookedDays[1]]}), "
           ."{$topBookedDays[2]} ({$bookings[$topBookedDays[2]]})";
