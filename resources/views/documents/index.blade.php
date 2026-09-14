<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload System</title>
</head>
<body style="
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 40px;
    background-color: #f4f4f9;
">

    <!-- Main Container -->
    <div style="
        max-width: 1000px;
        margin: 0 auto;
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    ">
        
        <h1 style="color: #333; margin-bottom: 30px; font-size: 32px;">File Upload System</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div style="
                background-color: #d4edda;
                color: #155724;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
                border-left: 4px solid #28a745;
            ">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div style="
                background-color: #f8d7da;
                color: #721c24;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
                border-left: 4px solid #dc3545;
            ">
                {{ session('error') }}
            </div>
        @endif

        <!-- ============================================ -->
        <!-- UPLOAD FORM -->
        <!-- ============================================ -->
        <div style="
            background-color: #f9f9f9;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 40px;
            border: 1px solid #ddd;
        ">
            <h2 style="color: #333; margin-top: 0; font-size: 24px;">Upload New File</h2>
            
            <!-- 
                enctype="multipart/form-data" BOHAT ZAROORI HAI!
                Yeh attribute batata hai ke form mein file upload ho rahi hai.
                Agar yeh nahi likhenge toh file upload nahi hogi.
            -->
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title Field -->
                <div style="margin-bottom: 20px;">
                    <label style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: bold;
                        color: #333;
                    ">File Title:</label>
                    
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g., My Resume, Project Report" style="
                        width: 100%;
                        padding: 12px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        font-size: 16px;
                        box-sizing: border-box;
                    " required>

                    @error('title')
                        <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- File Input -->
                <div style="margin-bottom: 20px;">
                    <label style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: bold;
                        color: #333;
                    ">Select File:</label>
                    
                    <input type="file" name="file" style="
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        font-size: 14px;
                        box-sizing: border-box;
                        background-color: white;
                    " required>

                    <small style="color: #666; display: block; margin-top: 5px;">
                        Allowed: JPG, PNG, PDF, DOC, DOCX | Max Size: 2MB
                    </small>

                    @error('file')
                        <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Storage Type Selection (Radio Buttons) -->
                <div style="margin-bottom: 20px;">
                    <label style="
                        display: block;
                        margin-bottom: 8px;
                        font-weight: bold;
                        color: #333;
                    ">Storage Type:</label>
                    
                    <div style="display: flex; gap: 30px; padding: 15px; background-color: white; border-radius: 4px; border: 1px solid #ddd;">
                        
                        <!-- Public Option -->
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="radio" name="disk" value="public" checked style="
                                margin-right: 8px;
                                transform: scale(1.2);
                                cursor: pointer;
                            ">
                            <div>
                                <strong style="color: #28a745;">Public</strong>
                                <small style="display: block; color: #666; font-size: 12px;">
                                    Anyone can access via URL
                                </small>
                            </div>
                        </label>

                        <!-- Private Option -->
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="radio" name="disk" value="local" style="
                                margin-right: 8px;
                                transform: scale(1.2);
                                cursor: pointer;
                            ">
                            <div>
                                <strong style="color: #dc3545;">Private</strong>
                                <small style="display: block; color: #666; font-size: 12px;">
                                    Secure download only
                                </small>
                            </div>
                        </label>

                    </div>

                    @error('disk')
                        <span style="color: #dc3545; font-size: 14px; margin-top: 5px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" style="
                    background-color: #007bff;
                    color: white;
                    padding: 14px 28px;
                    border: none;
                    border-radius: 4px;
                    font-size: 16px;
                    cursor: pointer;
                    font-weight: bold;
                    width: 100%;
                ">Upload File</button>

            </form>
        </div>

        <!-- ============================================ -->
        <!-- PUBLIC FILES LIST -->
        <!-- ============================================ -->
        <div style="margin-bottom: 40px;">
            <h2 style="color: #333; font-size: 24px; margin-bottom: 20px;">
                🌐 Public Files ({{ $publicFiles->count() }})
            </h2>

            @if($publicFiles->isNotEmpty())
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #28a745; color: white;">
                            <th style="padding: 12px; text-align: left;">Title</th>
                            <th style="padding: 12px; text-align: left;">Original Name</th>
                            <th style="padding: 12px; text-align: left;">Size</th>
                            <th style="padding: 12px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publicFiles as $file)
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 12px;">{{ $file->title }}</td>
                                <td style="padding: 12px;">{{ $file->original_name }}</td>
                                <td style="padding: 12px;">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                                <td style="padding: 12px; text-align: center;">
                                    <!-- View Button (Direct URL) -->
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" style="
                                        display: inline-block;
                                        background-color: #17a2b8;
                                        color: white;
                                        padding: 6px 12px;
                                        text-decoration: none;
                                        border-radius: 4px;
                                        margin-right: 5px;
                                        font-size: 13px;
                                    ">View</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('documents.destroy', $file->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this file?')" style="
                                            background-color: #dc3545;
                                            color: white;
                                            padding: 6px 12px;
                                            border: none;
                                            border-radius: 4px;
                                            cursor: pointer;
                                            font-size: 13px;
                                        ">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #999; text-align: center; padding: 20px;">No public files uploaded yet.</p>
            @endif
        </div>

        <!-- ============================================ -->
        <!-- PRIVATE FILES LIST -->
        <!-- ============================================ -->
        <div>
            <h2 style="color: #333; font-size: 24px; margin-bottom: 20px;">
                🔒 Private Files ({{ $privateFiles->count() }})
            </h2>

            @if($privateFiles->isNotEmpty())
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #dc3545; color: white;">
                            <th style="padding: 12px; text-align: left;">Title</th>
                            <th style="padding: 12px; text-align: left;">Original Name</th>
                            <th style="padding: 12px; text-align: left;">Size</th>
                            <th style="padding: 12px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($privateFiles as $file)
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 12px;">{{ $file->title }}</td>
                                <td style="padding: 12px;">{{ $file->original_name }}</td>
                                <td style="padding: 12px;">{{ number_format($file->file_size / 1024, 2) }} KB</td>
                                <td style="padding: 12px; text-align: center;">
                                    <!-- Download Button (Secure) -->
                                    <a href="{{ route('documents.download', $file->id) }}" style="
                                        display: inline-block;
                                        background-color: #007bff;
                                        color: white;
                                        padding: 6px 12px;
                                        text-decoration: none;
                                        border-radius: 4px;
                                        margin-right: 5px;
                                        font-size: 13px;
                                    ">Download</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('documents.destroy', $file->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this file?')" style="
                                            background-color: #dc3545;
                                            color: white;
                                            padding: 6px 12px;
                                            border: none;
                                            border-radius: 4px;
                                            cursor: pointer;
                                            font-size: 13px;
                                        ">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #999; text-align: center; padding: 20px;">No private files uploaded yet.</p>
            @endif
        </div>

    </div>

</body>
</html>