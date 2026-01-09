# DNSSEC Configuration Guide

This document provides step-by-step instructions for enabling DNSSEC (Domain Name System Security Extensions) for your domain to protect against DNS spoofing and cache poisoning attacks.

## What is DNSSEC?

DNSSEC adds cryptographic signatures to DNS records, ensuring that DNS responses are authentic and haven't been tampered with. This protects against:

-   DNS spoofing attacks
-   Cache poisoning
-   Man-in-the-middle attacks on DNS queries

## Prerequisites

-   Access to your DNS provider's control panel
-   Domain ownership verification
-   Basic understanding of DNS records

## Configuration by Provider

### Cloudflare

1. **Log in to Cloudflare Dashboard**

    - Go to https://dash.cloudflare.com
    - Select your domain

2. **Enable DNSSEC**

    - Navigate to **DNS** → **Settings**
    - Scroll to **DNSSEC** section
    - Click **Enable DNSSEC**

3. **Configure at Registrar**

    - Copy the DS record information provided by Cloudflare
    - Log in to your domain registrar
    - Add the DS record to your domain's DNSSEC settings

4. **Verify**
    - Wait 24-48 hours for propagation
    - Use online tools like https://dnssec-analyzer.verisignlabs.com

### AWS Route53

1. **Sign DNSSEC for Hosted Zone**

    ```bash
    aws route53 enable-hosted-zone-dnssec \
      --hosted-zone-id YOUR_ZONE_ID
    ```

2. **Get DS Records**

    ```bash
    aws route53 get-dnssec \
      --hosted-zone-id YOUR_ZONE_ID
    ```

3. **Add DS Records to Registrar**

    - Copy the DS records from the output
    - Add them to your domain registrar's DNSSEC settings

4. **Monitor Status**
    - Check status in Route53 console
    - Verify with DNSSEC validation tools

### Google Cloud DNS

1. **Enable DNSSEC**

    ```bash
    gcloud dns managed-zones update YOUR_ZONE_NAME \
      --dnssec-state on
    ```

2. **Get DS Records**

    ```bash
    gcloud dns managed-zones describe YOUR_ZONE_NAME
    ```

3. **Configure at Registrar**
    - Copy DS records from the output
    - Add to your domain registrar

### Other Providers

For other DNS providers:

1. Check provider documentation for DNSSEC support
2. Look for "DNSSEC" or "Security" settings in control panel
3. Follow provider-specific instructions
4. Always add DS records to your domain registrar

## Verification

### Online Tools

-   **Verisign DNSSEC Analyzer**: https://dnssec-analyzer.verisignlabs.com
-   **DNSViz**: https://dnsviz.net
-   **DNSSEC Debugger**: https://dnssec-debugger.verisignlabs.com

### Command Line

```bash
# Check DNSSEC validation
dig +dnssec yourdomain.com

# Verify DNSKEY records
dig DNSKEY yourdomain.com +short

# Check DS records at parent zone
dig DS yourdomain.com +trace
```

## Troubleshooting

### Common Issues

**DNSSEC validation fails**

-   Ensure DS records are correctly added to registrar
-   Wait for full DNS propagation (24-48 hours)
-   Verify clock synchronization on DNS servers

**Broken chain of trust**

-   Check that DS records match DNSKEY records
-   Verify parent zone has correct DS records
-   Ensure all signatures are valid and not expired

**Performance issues**

-   DNSSEC adds minimal overhead (typically <5%)
-   Consider using NSEC3 for better privacy
-   Monitor DNS query response times

## Best Practices

1. **Regular Monitoring**

    - Set up alerts for DNSSEC validation failures
    - Monitor key expiration dates
    - Regularly test with validation tools

2. **Key Management**

    - Use automated key rotation if available
    - Keep backup of zone signing keys
    - Document key rollover procedures

3. **Documentation**
    - Document your DNSSEC configuration
    - Keep records of DS record changes
    - Maintain emergency contact information

## Security Considerations

-   DNSSEC protects DNS integrity but doesn't encrypt DNS queries
-   Consider using DNS over HTTPS (DoH) or DNS over TLS (DoT) for privacy
-   Combine DNSSEC with other security measures (HTTPS, HSTS, etc.)

## Additional Resources

-   **ICANN DNSSEC Guide**: https://www.icann.org/resources/pages/dnssec-what-is-it-why-important-2019-03-05-en
-   **Cloudflare DNSSEC**: https://www.cloudflare.com/dns/dnssec/how-dnssec-works/
-   **RFC 4033-4035**: Official DNSSEC specifications

## Support

If you encounter issues:

1. Contact your DNS provider's support
2. Consult your domain registrar's documentation
3. Use DNSSEC validation tools to identify specific problems
