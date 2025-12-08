<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;


class ContactController extends Controller
{
    /**
     * Hiển thị trang liên hệ
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Xử lý gửi form liên hệ
     */
    public function submit(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.max' => 'Họ và tên không được quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email không được quá 255 ký tự',
            'phone.max' => 'Số điện thoại không được quá 20 ký tự',
            'subject.required' => 'Vui lòng nhập chủ đề',
            'subject.max' => 'Chủ đề không được quá 255 ký tự',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 10 ký tự',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Lưu vào database
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'pending', // pending, processing, resolved
            ]);

            // Gửi email thông báo cho admin
            $this->sendNotificationToAdmin($contact);

            // Gửi email xác nhận cho khách hàng
            $this->sendConfirmationToCustomer($contact);

            return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau!')
                ->withInput();
        }
    }

    /**
     * Gửi email thông báo cho admin
     */
    private function sendNotificationToAdmin($contact)
    {
        try {
            Mail::send('emails.contact-admin', ['contact' => $contact], function ($message) use ($contact) {
                $message->to(config('mail.admin_email', 'bachfanscp10@gmail.com'))
                    ->subject('Tin nhắn liên hệ mới từ: ' . $contact->name);
            });
        } catch (\Exception $e) {
            // Log lỗi nếu gửi email thất bại
            Log::error('Send admin email failed: ' . $e->getMessage());
        }
    }

    /**
     * Gửi email xác nhận cho khách hàng
     */
    private function sendConfirmationToCustomer($contact)
    {
        try {
            Mail::send('emails.contact-customer', ['contact' => $contact], function ($message) use ($contact) {
                $message->to($contact->email)
                    ->subject('Cảm ơn bạn đã liên hệ với TechStore');
            });
        } catch (\Exception $e) {
            // Log lỗi nếu gửi email thất bại
            Log::error('Send customer email failed: ' . $e->getMessage());
        }
    }
}