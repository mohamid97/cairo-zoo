<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Expense;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ExpenseController extends Controller
{
    // index
    public function index()
    {
        $expenses = Expense::with(['expenseAmounts' => function($query) {
            $query->orderBy('date', 'desc');
        }])->latest()->paginate(10);

        return view('admin.expense.index', compact('expenses'));
    }


    public function add()
    {
        return view('admin.expense.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,variable',
            'amount' => 'nullable|numeric',
            'date' => 'nullable|date',
        ]);

        $expense = Expense::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);
        if ($request->filled('amount') && $request->filled('date')) {
            $expense->expense()->create([
                'date' => $request->date,
                'amount' => $request->amount,
            ]);
        }
        Alert::success('success', 'Expense created successfully.');
        return redirect()->route('admin.expense.index');

    }

    public function edit($id)
    {
        $expense = Expense::with('latestAmount')->findOrFail($id);
        return view('admin.expense.update', compact('expense'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $expense = Expense::findOrFail($id);
        $year = date('Y', strtotime($request->date));
        $month = date('m', strtotime($request->date));
        $existingAmount = $expense->expense()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->first();

        if ($existingAmount) {
            $existingAmount->amount = $request->amount;
            $existingAmount->date = $request->date;
            $existingAmount->save();
        } else {
            $expense->expense()->create([
                'amount' => $request->amount,
                'date' => $request->date,
            ]);
        }

        Alert::success('success', 'Expense updated successfully.');
        return redirect()->route('admin.expense.index');

    }


    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->expenseAmounts()->delete();
        $expense->delete();
        Alert::success('success', 'Expense deleted successfully.');
        return redirect()->back();

    }








}
