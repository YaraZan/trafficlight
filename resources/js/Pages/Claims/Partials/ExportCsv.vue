<script setup>
import Button from '@/Components/Button.vue';
import * as XLSX from 'xlsx';
import * as fs from 'fs';

const props = defineProps({
    claims: {
        type: Array
    }
});

function exportToCsv() {
    // Map props.claims to only include the fields you want in the CSV
    const filteredData = props.claims.map((claim) => ({
        "Скважина": claim.WellName.trim(), // trim any extra spaces
        "Старое значение": claim.OldValue !== null ? ` ${claim.OldValue}` : "Пусто",
        "Новое значение": claim.Value !== null ? ` ${claim.Value}` : "Пусто",
        "Дата": claim.Dat, // Keep this as is since it's a date field
        "Статус": claim.StatusName,
        "Пользователь": claim.UserName,
        "Категория": claim.CatName,
    }));

    // Convert the filtered array of objects to a worksheet
    const worksheet = XLSX.utils.json_to_sheet(filteredData);

    // Create a new workbook
    const workbook = XLSX.utils.book_new();

    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

    // Set delimiter to semicolon (;) for regions like Russia where Excel expects this
    const csv = XLSX.write(workbook, { bookType: 'csv', type: 'string', FS: ";" });

    // Create a Blob with proper encoding for UTF-8
    const blob = new Blob([`\uFEFF${csv}`], { type: 'text/csv;charset=utf-8;' });

    // Create a download link
    const link = document.createElement("a");
    const now = new Date();
    const nd = `${now.getFullYear()}-${now.getMonth() + 1}-${now.getDate()}_${now.getHours()}.${now.getMinutes()}`;
    const filename = `Заявки_${nd}.csv`;

    if (navigator.msSaveBlob) {
        // For Internet Explorer
        navigator.msSaveBlob(blob, filename);
    } else {
        // For other browsers
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

</script>

<template>
    <Button @click="exportToCsv()" text="Экспорт в CSV">
        <template #prefix>
            <svg class="stroke-gray-400" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12.1575C5 10.2225 5 5.54512 5 5.54512C5 5.24406 5.24406 5 5.54512 5H12M5 12.1575C13.5153 12.1663 26.8049 12.1801 26.8049 12.1801M5 12.1575C5 15.2348 5 20 5 20M26.8049 12.1801V5.54512C26.8049 5.24406 26.5608 5 26.2598 5H12M26.8049 12.1801V15.5V20M5 20V26.2598C5 26.5608 5.24406 26.8049 5.54512 26.8049H12M5 20H26.8049M26.8049 20V26.2598C26.8049 26.5608 26.5608 26.8049 26.2598 26.8049H12M12 5V26.8049" stroke-width="2.22" stroke-linecap="round"/>
            </svg>
        </template>
    </Button>
</template>
