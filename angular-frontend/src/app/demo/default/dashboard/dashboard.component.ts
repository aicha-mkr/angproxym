import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RecapitulatifsService } from 'src/app/services/recapitulatifs.service'; // Assurez-vous du chemin correct
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { MonthlyBarChartComponent } from './monthly-bar-chart/monthly-bar-chart.component';
import { IncomeOverviewChartComponent } from './income-overview-chart/income-overview-chart.component';
import { AnalyticsChartComponent } from './analytics-chart/analytics-chart.component';
import { SalesReportChartComponent } from './sales-report-chart/sales-report-chart.component';
import { IconService } from '@ant-design/icons-angular';
import { FallOutline, GiftOutline, MessageOutline, RiseOutline, SettingOutline } from '@ant-design/icons-angular/icons';

@Component({
  selector: 'app-default',
  standalone: true,
  imports: [
    CommonModule,
    SharedModule,
    MonthlyBarChartComponent,
    IncomeOverviewChartComponent,
    AnalyticsChartComponent,
    SalesReportChartComponent
  ],
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DefaultComponent implements OnInit {
  // Injecter le service
  constructor(private recapitulatifsService: RecapitulatifsService, private iconService: IconService) {
    this.iconService.addIcon(...[RiseOutline, FallOutline, SettingOutline, GiftOutline, MessageOutline]);
  }

  // Définir les variables
  AnalyticEcommerce = [
    {
      title: 'CHIFFRES D’AFFAIRES',
      amount: '0', // Initialiser avec des valeurs par défaut
      background: 'bg-light-primary ',
      border: 'border-primary',
      icon: 'rise',
      percentage: '0%',
      color: 'text-primary',
      number: '0'
    },
    {
      title: 'NOMBRE D’UTILISATEURS',
      amount: '0',
      background: 'bg-light-primary ',
      border: 'border-primary',
      icon: 'rise',
      percentage: '0%',
      color: 'text-primary',
      number: '0'
    },
    {
      title: 'MOYENNE DES VENTES',
      amount: '0',
      background: 'bg-light-warning ',
      border: 'border-warning',
      icon: 'fall',
      percentage: '0%',
      color: 'text-warning',
      number: '0'
    },
    {
      title: 'NOMBRE DE COMMANDES',
      amount: '0',
      background: 'bg-light-warning ',
      border: 'border-warning',
      icon: 'fall',
      percentage: '0%',
      color: 'text-warning',
      number: '0'
    }
  ];

  transaction = [
    {
      background: 'text-success bg-light-success',
      icon: 'gift',
      title: 'Order #002434',
      time: 'Today, 2:00 AM',
      amount: '+ $1,430',
      percentage: '78%'
    },
    {
      background: 'text-primary bg-light-primary',
      icon: 'message',
      title: 'Order #984947',
      time: '5 August, 1:45 PM',
      amount: '- $302',
      percentage: '8%'
    },
    {
      background: 'text-danger bg-light-danger',
      icon: 'setting',
      title: 'Order #988784',
      time: '7 hours ago',
      amount: '- $682',
      percentage: '16%'
    }
  ];

  ngOnInit(): void {
    this.loadKPIData();
  }

  loadKPIData(): void {
    this.recapitulatifsService.getKPIData().subscribe(data => {
      this.AnalyticEcommerce = [
        {
          title: 'CHIFFRES D’AFFAIRES',
          amount: data.totalRevenue.toLocaleString(),
          background: 'bg-light-primary ',
          border: 'border-primary',
          icon: 'rise',
          percentage: '59.3%', // mise à jour en fonction des données baed
          color: 'text-primary',
          number: data.totalRevenue.toLocaleString()
        },
        {
          title: 'NOMBRE D’UTILISATEURS',
          amount: data.totalEmployees.toLocaleString(),
          background: 'bg-light-primary ',
          border: 'border-primary',
          icon: 'rise',
          percentage: '70.5%', // mise à jour en fonction des données baed
          color: 'text-primary',
          number: data.totalEmployees.toLocaleString()
        },
        {
          title: 'MOYENNE DES VENTES',
          amount: data.averageSales.toLocaleString(),
          background: 'bg-light-warning ',
          border: 'border-warning',
          icon: 'fall',
          percentage: '27.4%', // mise à jour en fonction des données baed
          color: 'text-warning',
          number: data.averageSales.toLocaleString()
        },
        {
          title: 'NOMBRE DE COMMANDES',
          amount: data.totalOrders.toLocaleString(),
          background: 'bg-light-warning ',
          border: 'border-warning',
          icon: 'fall',
          percentage: '27.4%', // mise à jour en fonction des données baed
          color: 'text-warning',
          number: data.totalOrders.toLocaleString()
        }
      ];
    });
  }

  trackByTitle(index: number, item: any): string {
    return item.title;
  }
}
