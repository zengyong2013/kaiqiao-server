<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 用户端
Route::group('web', function(){
    // Route::post('user/add', 'index/Index/addUser');
    // Route::post('activity/get', 'index/Index/getActivity');
    // Route::post('story/get', 'index/Index/getStoryByUserIdAndActivityId');
    // Route::post('story/match', 'index/Index/matchStory');
    // Route::post('story/add', 'index/Index/addStory');
});

// 管理端
Route::post('index/admin/login', 'index/IndexUser/adminLogin');
Route::post('index/login', 'index/IndexUser/login');
Route::group('index', function(){
    Route::get('user/list', 'index/IndexUser/userList');
    Route::post('user/add', 'index/IndexUser/add');
    Route::post('user/update', 'index/IndexUser/update');

    Route::get('testType/bigType/list', 'index/IndexTestType/getTestTypeListByBigType');
    Route::get('testType/group/list', 'index/IndexTestType/getTestTypeListByGroup');

    Route::get('test/detail', 'index/IndexTest/detail');
    Route::post('test/add', 'index/IndexTest/add');
    Route::post('test/update', 'index/IndexTest/update');
    Route::get('test/list', 'index/IndexTest/getTestList');

    Route::get('question/list', 'index/IndexQuestion/getList');
    Route::post('question/add', 'index/IndexQuestion/add');
    Route::post('question/update', 'index/IndexQuestion/update');
    Route::post('question/delete', 'index/IndexQuestion/delete');

    Route::get('option/testId/list', 'index/IndexQuestion/getAllOptionByTestId');
    Route::get('option/questionId/list', 'index/IndexQuestionOption/getByQuestionId');
    Route::post('option/add', 'index/IndexQuestionOption/add');
    Route::post('option/delete', 'index/IndexQuestionOption/delete');
    Route::post('option/update', 'index/IndexQuestionOption/update');

    Route::post('answer/add', 'index/IndexUserAnswer/add');

    Route::get('group/list', 'index/IndexGroup/getGroupList');
    Route::get('group/testType/list', 'index/IndexGroup/getTestType');
    Route::post('group/add', 'index/IndexGroup/add');
    Route::post('group/delete', 'index/IndexGroup/delete');
    Route::post('group/update', 'index/IndexGroup/update');
    Route::post('group/testType/add', 'index/IndexGroup/addTestType');
    Route::post('group/testType/delete', 'index/IndexGroup/deleteTestType');

    Route::post('article/add', 'index/IndexArticle/add');
    Route::post('article/update', 'index/IndexArticle/update');
    Route::post('article/delete', 'index/IndexArticle/delete');
    Route::get('article/list', 'index/IndexArticle/getList');
    Route::get('article/list2', 'index/IndexArticle/getList2');
    Route::get('article/detail', 'index/IndexArticle/detail');

    Route::post('friend/add', 'index/IndexFriend/add');
    Route::post('friend/delete', 'index/IndexFriend/delete');
    Route::get('friend/list', 'index/IndexFriend/getFriendList');

    Route::post('friendEnjoy/add', 'index/IndexFriendEnjoy/add');
    Route::post('friendEnjoy/delete', 'index/IndexFriendEnjoy/delete');
    Route::get('friendEnjoy/list', 'index/IndexFriendEnjoy/getFriendEnjoyList');

    //导出excel
    Route::get('user/listExport', 'index/IndexUser/exportUserData'); // 所有用户
    Route::get('answer/answerExport', 'index/IndexUserAnswer/exportAnswerData'); // 单个用户的答题数据


    // Route::get('story/detail', 'index/Admin/getStoryDetail');
    // Route::get('activity/list', 'index/Admin/getActivityList');
    // Route::get('activty/detail', 'index/Admin/getActivityDetail');

    // Route::post('reset', 'index/Admin/updatePassword');
    // Route::post('activity/add', 'index/Admin/addActivity');
    // Route::post('activity/delete', 'index/Admin/deleteActivity');
    // Route::post('activity/update', 'index/Admin/updateActivity');
})->middleware(app\http\middleware\CheckToken::class);
Route::allowCrossDomain();


return [];
