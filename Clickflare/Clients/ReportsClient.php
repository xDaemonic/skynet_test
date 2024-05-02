<?php

namespace App\Services\Clickflare\Clients;

use App\Services\Clickflare\Contracts\ClickFlareApiClient;
use App\Services\Clickflare\Helpers\UrlRegistry;
use Carbon\Carbon;

class ReportsClient extends ClickFlareApiClient
{
    protected array $default_options = [
        "conversionTimestamp" => "visit",
        "timezone" => "America/Los_Angeles",
        "includeAll" => true,
        "sortBy" => "uniqueVisits",
        "orderType" => "desc",
        "page" => 1,
        "pageSize" => 1000,
        "groupBy" => [
            "campaignID",
        ],
        "metrics" => [
            "campaignID",
            "campaignTrafficSourceId",
            "visits",
            "dynamicPayout",
            "cpa",
            "conversions",
            "cost",
            "revenue",
            "profit",
            "roi",
            "uniqueVisits",
            "visitCvr",
            "customConversion1",
            "epv",
            "cpv",
            "roas",
            "customRevenue1",
            "campaignName",
        ],
    ];

    protected function endpointKey():string
    {
        return 'reports';
    }

    public function __construct()
    {
        $this->default_options = $this->makeOptions([
            'startDate' => Carbon::now()->format('Y-m-d 00:00:00'),
            'endDate' => Carbon::now()->format('Y-m-d 23:59:59'),
        ]);
    }

    /**
     * @param \Carbon\Carbon $date
     * @return array
     * @throws \Spatie\LaravelIgnition\Exceptions\InvalidConfig
     */
    public function getReport(Carbon $report_date): array
    {
        $options = $this->makeOptions([
            'startDate' => $report_date->format('Y-m-d 00:00:00'),
            'endDate' => $report_date->format('Y-m-d 23:59:59'),
        ]);

        $report = $this->getData($options);
        if (!empty($report)) {
            $pages_cnt = ((int) ceil($report['totals']['counter'] / $options['pageSize']));
            for ($i = ($options['page'] + 1); $i <= $pages_cnt; $i++) {
                $options['page'] = $i;
                $report_second = $this->getData($options);
                $report = $this->mergeReports($report, $report_second);
            }
        }

        return $report;
    }

    private function mergeReports(array &$report_first, array $report_second): array
    {
        if (empty($report_second)) return $report_first;

        $report_first['items'] = array_merge($report_first['items'], $report_second['items']);
        return $report_first;
    }
};
