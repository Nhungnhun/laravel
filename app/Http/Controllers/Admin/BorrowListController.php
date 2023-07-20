<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Constants\AppConstants;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use Illuminate\Support\Carbon;

class BorrowListController extends Controller
{
    public function index(Request $request)
    {

        $search = trim($request->input('search'));
        $isSearchSubmitted = !empty($search); // Kiểm tra xem đã submit search chưa

        $borrows = BorrowedBook::query()
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('code', 'LIKE', '%' . $search . '%');
                });
            })
            ->paginate(AppConstants::PAGE);

    $currentPage = $borrows->currentPage();
    $startIndex = ($currentPage - 1) * AppConstants::PAGE;
    $date=new Carbon();

    if (!is_numeric($currentPage) || $currentPage < 1 || $currentPage > $borrows->lastPage()) {
            return redirect()->back();
    }
    return view('admin.borrow.index', compact('borrows', 'startIndex', 'date'));
    }

    public function detail($id)
    {
    $borrows = BorrowedBook::findOrFail($id);;
    return view('admin.borrow.detail', compact('borrows'));
    }

    public function edit($id)
    {
    $borrows = BorrowedBook::findOrFail($id);;
    return view('admin.borrow.edit', compact('borrows'));
    }

    public function borrow($id){
    $borrow = BorrowedBook::findOrFail($id);

    $userName = $borrow->user->name;
    $email = $borrow->user->email;
    $bookName = $borrow->book->name;
    $code = $borrow->code;
    
    $borrow->status='Đã duyệt';
    $borrow->save();

    dispatch(new SendEmailJob($email, $userName, $bookName,$code));
    return redirect()->route('borrow.list')->with('msg', 'Borrow book successfully !');
}

public function update(Request $request, $id)
{
    $borrow = BorrowedBook::findOrFail($id);
    $user = $borrow->user;

    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $isUpdated = $user->save();

    if ($isUpdated) {
        return redirect()->route('borrow.list')->with('msg', 'Edit successfully!');
    }
}

    public function delete($id)
    {
        $delete = BorrowedBook::findOrFail($id);
        $delete->delete();
    
        return redirect()->route('borrow.list')->with('msg', 'Delete borrow successfully !');
    }

    public function borrowsucess($id)
    {
        $sucess = BorrowedBook::findOrFail($id);
        $book=$sucess->book;
        if ($book->quantity > 0) {
            $book->quantity = $book->quantity - 1;
            $book->save();
        } else {
            return redirect()->route('borrow.list')->with('error', 'Không thể thực hiện mượn sách bây giờ!');
        }
    
        $sucess->status = 'Đang mượn';
        $sucess->borrow_date = new Carbon();
        $sucess->save();
        return redirect()->route('borrow.list')->with('msg', 'Success borrow successfully!');
    }

    public function givebook($id)
    {
        $give = BorrowedBook::findOrFail($id);
        $book=$give->book;
        $book->quantity = $book->quantity + 1;
        $book->save();
        $give->delete();
        return redirect()->route('borrow.list')->with('msg', 'Give book back successfully!');
    }
    
}
