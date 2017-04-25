<?php

namespace App\Http\Controllers;

use App\Book;
use App\Book_i18n;
use App\Http\Requests;
use App\Language;
use App\Sort;
use Config;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Image;
use Input;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        if (Sort::find((new Book())->getTable()) == null) {
            $this->sort();
        }

        $sort = new Sort(Sort::find((new Book())->getTable())->toArray());
        $mode = unserialize($sort->mode);

        $perPage = Config::get('app.pages_config');
        $totalPage = ceil(Book::count() / $perPage);

        $page = intval(Input::get('page'));
        if ($page <= 0) {
            $page = 1;
        } elseif ($page > $totalPage) {
            $page = $totalPage;
        }
        Input::merge(['page' => $page]);

        $table = Book::orderBy($mode['field'], $mode['direction'])
            ->paginate(\Config::get('app.pages_config'));
        return view('book_index')->with('table', $table)->with('direction', $mode['direction']);
    }

    public function sort()
    {
        $option = array('asc', 'desc');
        $data = Sort::find((new Book())->getTable());
        $field = 'rand_id';
        $sort = new Sort();
        if ($data == null) {
            $sort->item = (new Book())->getTable();
            $sort->mode = serialize(
                [
                    'field' => $field,
                    'direction' => $option[0]
                ]
            );
        } else {
            $sort = new Sort($data->toArray());
            $mode = unserialize($sort->mode);

            $direction = $option[0];
            if ($mode['direction'] == $option[0]) {
                $direction = $option[1];
            } else if ($mode['direction'] == $option[1]) {
                $direction = $option[0];
            }

            $sort->mode = serialize([
                'field' => $field,
                'direction' => $direction
            ]);
        }

        Sort::updateOrCreate([$sort->getKeyName() => $sort->item], $sort->toArray());

        return $this->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $languages = Language::all();
        return view('book_create')->with('languages', $languages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $rules = null;
        $messages = null;
        $upload_option = (boolean)Input::get('upload_option');
        if ($upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.required' => '<p>．請上傳書封。</p>',
                'upload_file.mimes' => '<p>．請上傳正確格式圖片。</p>'
            );
        } else {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'cover' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'cover.required' => '<p>．請輸入書封。</p>',
                'cover.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        //Log::info("data --------------------------- " . dump($request));

        // 2 不用處理檔案 copy , 1 要處理檔案 copy

        $cover = null;

        if (Input::hasFile('upload_file')) {

            $imageName = Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            Input::file('upload_file')->move(
                base_path() . '/public/books/', $imageName
            );

            // width 固定

            $width = Image::make(base_path() . '/public/books/' . $imageName)->width();

            $height = Image::make(base_path() . '/public/books/' . $imageName)->height();

            $new_height = \Config::get('app.books_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

            Image::make(base_path() . '/public/books/' . $imageName)
                ->resize(\Config::get('app.books_image_width'), $new_height)
                ->save(public_path('books/' . $imageName));


            $cover = "books/$imageName";

        } else {
            $cover = Input::get('cover');
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('book_i18ns');

        Input::merge(array(
            'view' => boolval(Input::get('view')),
            'upload_option' => boolval(Input::get('upload_option')),
            'cover' => $cover,
            'book_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $book = new Book(Input::all());
        $book->save();

        $book_i18ns = array();
        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Book_i18n();
            $i18n->language = $lid;
            $i18n->book()->associate($book);

            if (!empty($i18ns[$lid])) {
                $i18n = new Book_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            $book_i18ns[] = $i18n;
        }

        $book->book_i18ns()->saveMany($book_i18ns);

        return redirect()->route('book.index')
            ->with('success', '新增資料成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //TODO
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
        if (Book::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $book = Book::find($id);
        $languages = Language::all();

        return view('book_edit')->with('book', $book)->with('languages', $languages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
        if (Book::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $book = new Book(Book::find($id)->toArray());
        $db_upload_option = (boolean)$book->upload_option;
        $upload_option = (boolean)Input::get('upload_option');

        $rules = null;
        $messages = null;
        if ($db_upload_option && $upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'mimes:png,jpeg,gif'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.mimes' => '<p>．請上傳正確格式圖片。</p>'
            );
        } elseif ($db_upload_option && !$upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'cover' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'cover.required' => '<p>．請輸入書封。</p>',
                'cover.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        } elseif (!$db_upload_option && $upload_option) {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'upload_file' => 'required|mimes:png,jpeg,gif'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'upload_file.required' => '<p>．請上傳書封。</p>',
                'upload_file.mimes' => '<p>．請上傳正確格式圖片。</p>'
            );
        } else {
            $rules = array(
                'book_name' => 'required',
                'url' => 'required|regex:/^http([s]?):\/\/.*/',
                'cover' => 'required|regex:/^http([s]?):\/\/.*/'
            );

            $messages = array(
                'book_name.required' => '<p>．請輸入書名。</p>',
                'url.required' => '<p>．請輸入連結。</p>',
                'url.regex' => '<p>．連結格式必須為網址(含http://)。</p>',
                'cover.required' => '<p>．請輸入書封。</p>',
                'cover.regex' => '<p>．圖檔網址格式必須為網址(含http://)。</p>'
            );
        }

        $this->validate($request, $rules, $messages);

        //Log::info("data --------------------------- " . dump($request));

        // 2 不用處理檔案 copy , 1 要處理檔案 copy

        $cover = $book->cover;
        if ($db_upload_option && $upload_option) {
            if (Input::hasFile('upload_file')) {

                $imageName = Input::file('upload_file');

                $imageName = time() . "-" . $imageName->getClientOriginalName();

                Input::file('upload_file')->move(
                    base_path() . '/public/books/', $imageName
                );

                // width 固定

                $width = Image::make(base_path() . '/public/books/' . $imageName)->width();

                $height = Image::make(base_path() . '/public/books/' . $imageName)->height();

                $new_height = \Config::get('app.books_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

                Image::make(base_path() . '/public/books/' . $imageName)
                    ->resize(\Config::get('app.books_image_width'), $new_height)
                    ->save(public_path('books/' . $imageName));


                $cover = "books/$imageName";

                // 需要刪除舊有 image 檔案

                File::delete(\Config::get('app.books_image_folder') . $book->cover);
            } else {
                //$cover = $book->cover;
            }

        } elseif ($db_upload_option && !$upload_option) {

            $cover = Input::get('cover');

            // 需要刪除舊有 image 檔案

            File::delete(\Config::get('app.books_image_folder') . $book->cover);

        } elseif (!$db_upload_option && $upload_option) {

            $imageName = Input::file('upload_file');

            $imageName = time() . "-" . $imageName->getClientOriginalName();

            Input::file('upload_file')->move(
                base_path() . '/public/books/', $imageName
            );

            // width 固定

            $width = Image::make(base_path() . '/public/books/' . $imageName)->width();

            $height = Image::make(base_path() . '/public/books/' . $imageName)->height();

            $new_height = \Config::get('app.books_image_width') * $height / $width;

//                Log::info('height - ' . $height . ', width - ' . $width . ", new_height " . $new_height);

            Image::make(base_path() . '/public/books/' . $imageName)
                ->resize(\Config::get('app.books_image_width'), $new_height)
                ->save(public_path('books/' . $imageName));


            $cover = "books/$imageName";

        } else {
            $cover = Input::get('cover');
        }

        $languages = Language::where('id', '>', 0)->get();
        $i18ns = Input::get('book_i18ns');

        Input::merge(array(
            'view' => boolval(Input::get('view')),
            'upload_option' => boolval(Input::get('upload_option')),
            'cover' => $cover,
            'book_i18ns' => null
        ));
        Input::merge(array_map('trim', Input::all()));

        $book->fill(Input::all());
        Book::whereId($id)->update($book->toArray());

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lid = $languages[$i]->id;
            $i18n = new Book_i18n();
            $i18n->book_id = $id;
            $i18n->language = $lid;

            if (!empty($i18ns[$lid])) {
                $i18n = new Book_i18n($i18n->toArray() + array_map('trim', $i18ns[$lid]));
            }

            if (Book_i18n::whereBookId($id)->whereLanguage($lid)->exists()) {
                Book_i18n::whereBookId($id)->whereLanguage($lid)->update($i18n->toArray());
            } else {
                $i18n->save();
            }
        }

        return redirect()->route('book.index')
            ->with('success', '更新資料成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        if (Book::whereId($id)->count() == 0) {
            return view('errors.404');
        }

        $book = new Book(Book::find($id)->toArray());
        File::delete(\Config::get('app.books_image_folder') . $book->cover);

        Book_i18n::whereBookId($id)->delete();
        Book::whereId($id)->delete();

        return redirect()->route('book.index')
            ->with('success', '刪除資料成功');
    }
}
