<?php

namespace App\Http\Controllers;

use App\Invoice_Booking;
use Illuminate\Http\Request;

class InvoiceBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice_Booking  $invoice_Booking
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_Booking $invoice_Booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice_Booking  $invoice_Booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_Booking $invoice_Booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice_Booking  $invoice_Booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_Booking $invoice_Booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice_Booking  $invoice_Booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice_Booking $invoice_Booking)
    {
        //
    }
}
