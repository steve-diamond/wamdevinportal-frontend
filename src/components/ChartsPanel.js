import React, { useState } from 'react';
import {
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend,
  ResponsiveContainer, Cell, LineChart, Line, PieChart, Pie,
} from 'recharts';

const COLORS = ['#0f4d92', '#16a34a', '#0891b2', '#d97706', '#7c3aed'];

const CHART_TYPES = [
  { id: 'bar',  label: '📊 Bar' },
  { id: 'line', label: '📈 Line' },
  { id: 'pie',  label: '🥧 Pie' },
];

function CustomTooltip({ active, payload, label }) {
  if (!active || !payload?.length) return null;
  return (
    <div style={{
      background: '#fff', border: '1px solid #e2e8f0', borderRadius: 8,
      padding: '8px 14px', boxShadow: '0 4px 12px rgba(0,0,0,0.1)', fontSize: 13,
    }}>
      <div style={{ fontWeight: 700, marginBottom: 4, color: '#0f172a' }}>{label || payload[0]?.name}</div>
      {payload.map(p => (
        <div key={p.dataKey || p.name} style={{ color: p.fill || p.color }}>
          {p.name || p.dataKey}: <strong>{typeof p.value === 'number' ? p.value.toLocaleString() : p.value}</strong>
        </div>
      ))}
    </div>
  );
}

export default function ChartsPanel({ stats = [] }) {
  const [chartType, setChartType] = useState('bar');

  // Normalise: accept both { name, count } and { name, value }
  const data = stats
    .filter(s => s && s.name != null)
    .map(s => ({ name: s.name, value: Number(s.value ?? s.count ?? 0) }));

  if (!data.length) {
    return (
      <div style={{ textAlign: 'center', padding: 40, color: 'var(--text-muted, #94a3b8)' }}>
        <div style={{ fontSize: 36, marginBottom: 8 }}>📊</div>
        <div>No data available</div>
      </div>
    );
  }

  return (
    <div>
      {/* Chart type selector */}
      <div
        role="group"
        aria-label="Chart type"
        style={{ display: 'flex', gap: 6, marginBottom: 16, flexWrap: 'wrap' }}
      >
        {CHART_TYPES.map(ct => (
          <button
            key={ct.id}
            onClick={() => setChartType(ct.id)}
            aria-pressed={chartType === ct.id}
            style={{
              padding: '5px 12px', fontSize: 12, fontWeight: 600, border: '1px solid',
              borderRadius: 20, cursor: 'pointer',
              background: chartType === ct.id ? 'var(--primary, #0f4d92)' : 'transparent',
              color: chartType === ct.id ? '#fff' : 'var(--text-secondary, #475569)',
              borderColor: chartType === ct.id ? 'var(--primary, #0f4d92)' : 'var(--border, #e2e8f0)',
              transition: 'background 150ms, color 150ms',
            }}
          >
            {ct.label}
          </button>
        ))}
      </div>

      {/* Charts */}
      <div aria-label={`${chartType} chart`}>
        {chartType === 'bar' && (
          <ResponsiveContainer width="100%" height={220}>
            <BarChart data={data} margin={{ top: 4, right: 12, left: -10, bottom: 0 }}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f1f5f9" />
              <XAxis dataKey="name" tick={{ fontSize: 12 }} />
              <YAxis tick={{ fontSize: 12 }} />
              <Tooltip content={<CustomTooltip />} />
              <Legend wrapperStyle={{ fontSize: 12 }} />
              <Bar dataKey="value" name="Count" radius={[4, 4, 0, 0]}>
                {data.map((_, i) => (
                  <Cell key={i} fill={COLORS[i % COLORS.length]} />
                ))}
              </Bar>
            </BarChart>
          </ResponsiveContainer>
        )}

        {chartType === 'line' && (
          <ResponsiveContainer width="100%" height={220}>
            <LineChart data={data} margin={{ top: 4, right: 12, left: -10, bottom: 0 }}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f1f5f9" />
              <XAxis dataKey="name" tick={{ fontSize: 12 }} />
              <YAxis tick={{ fontSize: 12 }} />
              <Tooltip content={<CustomTooltip />} />
              <Legend wrapperStyle={{ fontSize: 12 }} />
              <Line
                type="monotone"
                dataKey="value"
                name="Count"
                stroke={COLORS[0]}
                strokeWidth={2}
                dot={{ r: 4, fill: COLORS[0] }}
                activeDot={{ r: 6 }}
              />
            </LineChart>
          </ResponsiveContainer>
        )}

        {chartType === 'pie' && (
          <ResponsiveContainer width="100%" height={220}>
            <PieChart>
              <Pie
                data={data}
                dataKey="value"
                nameKey="name"
                cx="50%"
                cy="50%"
                outerRadius={80}
                label={({ name, percent }) =>
                  `${name} ${(percent * 100).toFixed(0)}%`
                }
                labelLine={false}
              >
                {data.map((_, i) => (
                  <Cell key={i} fill={COLORS[i % COLORS.length]} />
                ))}
              </Pie>
              <Tooltip content={<CustomTooltip />} />
              <Legend wrapperStyle={{ fontSize: 12 }} />
            </PieChart>
          </ResponsiveContainer>
        )}
      </div>
    </div>
  );
}

