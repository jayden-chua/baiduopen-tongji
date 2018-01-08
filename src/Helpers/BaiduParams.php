<?php

namespace BaiduOpen\Tongji\Helpers;

class BaiduParams
{
    const LOGIN_URL = 'https://api.baidu.com/sem/common/HolmesLoginService';

    const REPORT_URL = 'https://api.baidu.com/json/tongji/v1/ReportService';

    const DEFAULT_API_PUB_KEY = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDHn/hfvTLRXViBXTmBhNYEIJeG
GGDkmrYBxCRelriLEYEcrwWrzp0au9nEISpjMlXeEW4+T82bCM22+JUXZpIga5qd
BrPkjU08Ktf5n7Nsd7n9ZeI0YoAKCub3ulVExcxGeS3RVxFai9ozERlavpoTOdUz
EH6YWHP4reFfpMpLzwIDAQAB
-----END PUBLIC KEY-----';

    const METHOD_OVERVIEW_GET_TIME_TREND_REPORT = 'overview/getTimeTrendRpt';
    const METHOD_OVERVIEW_GET_DISTRICT_REPORT = 'overview/getDistrictRpt';
    const METHOD_OVERVIEW_GET_COMMON_TRACK_REPORT = 'overview/getCommonTrackRpt';
    const METHOD_PRO_PRODUCT_A = 'pro/product/a';
    const METHOD_TREND_TIME_A = 'trend/time/a';
    const METHOD_PRO_HOUR_A = 'pro/hour/a';
    const METHOD_SOURCE_ALL_A = 'source/all/a';
    const METHOD_SOURCE_ENGINE_A = 'source/engine/a';
    const METHOD_SOURCE_SEARCHWORD_A = 'source/searchword/a';
    const METHOD_SOURCE_LINK_A = 'source/link/a';
    const METHOD_VISIT_TOPPAGE_A = 'visit/toppage/a';
    const METHOD_VISIT_LANDINGPAGE_A = 'visit/landingpage/a';
    const METHOD_VISIT_TOPDOMAIN_A = 'visit/topdomain/a';
    const METHOD_VISIT_DISTRICT_A = 'visit/district/a';
    const METHOD_VISIT_WORLD_A = 'visit/world/a';

    const DEFAULT_METHOD_METRICS = [
        self::METHOD_OVERVIEW_GET_TIME_TREND_REPORT => [
            'method' => self::METHOD_OVERVIEW_GET_TIME_TREND_REPORT,
            'metrics' => 'pv_count, visitor_count, ip_count, bounce_ratio, avg_visit_time, trans_count, contri_pv',
            'max_results' => 0
        ],
        self::METHOD_OVERVIEW_GET_DISTRICT_REPORT => [
            'method' => self::METHOD_OVERVIEW_GET_DISTRICT_REPORT,
            'metrics' => 'pv_count',
            'max_results' => 0
        ],
        self::METHOD_OVERVIEW_GET_COMMON_TRACK_REPORT => [
            'method' => self::METHOD_OVERVIEW_GET_COMMON_TRACK_REPORT,
            'metrics' => 'pv_count',
            'max_results' => 0
        ],
        self::METHOD_PRO_PRODUCT_A => [
            'method' => self::METHOD_PRO_PRODUCT_A,
            'metrics' => 'show_count, clk_count, cost_count, ctr, cpm, pv_count, visit_count, visitor_count, 
                          new_visitor_count, new_visitor_ratio, in_visit_count, bounce_ration, avg_visit_time,
                          avg_visit_pages, arrival_ratio',
            'max_results' => 0
        ],
        self::METHOD_TREND_TIME_A => [
            'method' => self::METHOD_TREND_TIME_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio, 
                          avg_trans_cost, income, profit, roi',
            'max_results' => 0
        ],
        self::METHOD_SOURCE_ALL_A => [
            'method' => self::METHOD_SOURCE_ALL_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio',
            'max_results' => 0
        ],
        self::METHOD_SOURCE_ENGINE_A => [
            'method' => self::METHOD_SOURCE_ENGINE_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio',
            'max_results' => 0
        ],
        self::METHOD_SOURCE_SEARCHWORD_A => [
            'method' => self::METHOD_SOURCE_SEARCHWORD_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio',
            'max_results' => 0
        ],
        self::METHOD_SOURCE_LINK_A => [
            'method' => self::METHOD_SOURCE_LINK_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio',
            'max_results' => 0
        ],
        self::METHOD_VISIT_TOPPAGE_A => [
            'method' => self::METHOD_VISIT_TOPPAGE_A,
            'metrics' => 'pv_count, visitor_count, ip_count, visit1_count, outward_count, exit_count, 
                          average_stay_time, exit_ratio',
            'max_results' => 0
        ],
        self::METHOD_VISIT_LANDINGPAGE_A => [
            'method' => self::METHOD_VISIT_LANDINGPAGE_A,
            'metrics' => 'visit_count, visitor_count, new_visitor_count, new_visitor_ratio, ip_count, out_pv_count, 
                          bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio',
            'max_results' => 0
        ],
        self::METHOD_VISIT_TOPDOMAIN_A => [
            'method' => self::METHOD_VISIT_TOPDOMAIN_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, average_stay_time, avg_visit_pages',
            'max_results' => 0
        ],
        self::METHOD_VISIT_DISTRICT_A => [
            'method' => self::METHOD_VISIT_DISTRICT_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio',
            'max_results' => 0
        ],
        self::METHOD_VISIT_WORLD_A => [
            'method' => self::METHOD_VISIT_WORLD_A,
            'metrics' => 'pv_count, pv_ratio, visit_count, visitor_count, new_visitor_count, new_visitor_ratio, 
                          ip_count, bounce_ratio, avg_visit_time, avg_visit_pages, trans_count, trans_ratio',
            'max_results' => 0
        ]
    ];
}