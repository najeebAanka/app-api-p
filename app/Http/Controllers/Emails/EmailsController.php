<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;

class EmailsController extends Controller {

    function buildBookingObject($id) {
        $selects = ' bookings.id  ,bookings.requested_date  ,bookings.reply  ,bookings.updated_at ,bookings.selected_professional '
                . ' ,bookings.frequency_type ,bookings.grand_total ,bookings.vat ,bookings.subtotal,bookings.created_at ,'
                . ' bookings.status ,users.name  , users.phone '
                . ' , users.email, addresses.country ,addresses.lat , addresses.lng ,addresses.address2  '
                . ',addresses.address1 ,categories.title_en,categories.id as cat_id , bookings.grand_total';

        $sql = 'SELECT ' . $selects . ' , if(bookings.status'
                . '  = "pending", 1, 0) AS is_pending from bookings'
                . ' join users on users.id = bookings.user_id join addresses on'
                . ' bookings.address_id = addresses.id join booking_services on '
                . 'booking_services.booking_id=bookings.id join services on '
                . 'services.id=booking_services.service_id join categories '
                . 'on categories.id=services.category_id  where bookings.id = :id  ';

        $bookings = DB::select($sql, ['id' => $id]);
        return $bookings[0];
    }

    function sendBookingSubmittedEmail($id) {
        $booking = $this->buildBookingObject($id);
        \Illuminate\Support\Facades\Mail::to($booking->email)
                ->send(new \App\Mail\OrderSubmitted($booking));
    }

    function sendBookingChangedEmail($id) {
        $booking = $this->buildBookingObject($id);
        \Illuminate\Support\Facades\Mail::to($booking->email)
                ->send(new \App\Mail\OrderStatusChanged($booking));
    }

}
