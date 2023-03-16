<?php

function save_files($request){
    if(is_null($request)){
        return null;
    }
    $extions=$request->getclientoriginalextension();
    if(Str::contains('jpeg bmp png jpg', $extions)){
        $folder='\\image';
    }
    elseif(Str::contains('pdf', $extions)){
        $folder='\\Book';
    }
    else {
        $folder='\\audio';
    }
    $File_name=time().'.'.$extions;
    $File_epath = $request->move('Books'.$folder,$File_name);
    return $File_epath;
}

function validaor()
{
    return [
            'name' => 'required|max:150|string',
            'image'=>'mimes:jpeg,bmp,png,jpg|max:1999|required|image',
            'file_path'=>'mimes:pdf|required',
            'Publisher_id'=>'required',
            'description'=>'max:1000',
            'category_id'=>'required',
            // 'book_audio' => 'mimes:mp3'
    ];
}

function message_error()
{
    return [
        'name.required' => 'هدا الحقل مطلوب',
        'name.max'=>'اسم الكتاب يجب ان يكون اقل من 150 حرف',
        'name.string'=>'اسم الكتاب يجب ان يكون نص',
        // 'name.unique' => 'هذا الكتاب موجود ',
        'image.mimes' => 'هذا الصيغة غير مدعومة',
        'image.required' => 'هدا الحقل مطلوب' ,
        'image.max' => 'حجم الصورة كبير' ,
        'image.image'=>'هدا الحقل يجب ان يكون صورة',
        'file_path.mimes' => 'هذا الملف غير مدعوم',
        'file_path.required' => 'هدا الحقل مطلوب' ,
        'Publisher_id.required' => 'هدا الحقل مطلوب',
        'description.max' => 'هذ الحقل مطلوب',
        'category_id.required'=>'هدا الحقل مطلوب'
        // 'book_audio.mimes' => 'هذي الضيغة غير مدعومة' 
    ];
}