import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class RecapitulatifsService {
  private apiUrl = 'http://localhost:8000/api/recapitulatifs';

  constructor(private http: HttpClient) { }

  generateRecapitulatifs(): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/generate`, {}).pipe(
      tap(response => console.log('Generate API Response:', response))
    );
  }

  getKPIData(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/kpi`).pipe(
      tap(response => console.log('KPI API Response:', response))
    );
  }
}
