<?php

namespace App\Http\Controllers;

use App\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
class EmailTemplateController extends Controller
{ 


    private $events = [
        'on_registeration' => 'On Registration',
        'on_forgetpasword' => 'On Forget Pasword',
        'on_change_password' =>'On Change Password',
        'on_order' =>'On Order placed',
    ];
    /**email-templates
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $events =  $this->events;
        $templates_list = EmailTemplate::orderBy('id','desc')->get();
        return view('admin.pages.email_templates.index',compact('templates_list','events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        $events =  $this->events;
        $available_virables[] =  $this->getTableColumns('users');
        return view('admin.pages.email_templates.add',compact('events','available_virables'));
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
        $input = $request->except(['_token']);

        $validator =  Validator::make($input, [
            'template_name' => 'required|string|max:255',
            'template' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{
           $input['user_id'] = Auth::id();
           EmailTemplate::create($input);

           $topiscussesscreated= __('messages.templates Successfully Created');
           $request->session()->flash('status', $topiscussesscreated);

            return redirect('admin/email-templates');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events =  $this->events;
        $available_virables[] =  $this->getTableColumns('users');
        if($template = EmailTemplate::find($id)){
        return view('admin.pages.email_templates.edit',compact('events','available_virables','template'));
        }else{
        return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->except(['_token','_method']);
        $validator =  Validator::make($input, [
            'template_name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{
           $input['user_id'] = Auth::id();
           EmailTemplate::where('id',$id)->update($input);

           $topiscussesscreated= __('Email Templates Successfully Updated');
           $request->session()->flash('status', $topiscussesscreated);

            return redirect('admin/email-templates');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        //
    }


    public function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);

    }
}
